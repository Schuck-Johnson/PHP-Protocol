#Clojure Protocols for PHP

##What is a protocol?

See the Details.md file for more information

##Creating a protocol

1. Create an interface with the methods you want the protocol to implement.  The first 
parameter of each method in the interface needs to be the invoking object.
So create your interface like this

        interface ILookup
        {
            public function get($context, $key, $default = null);
            public function exists($context, $key);
        }
    
    not like this
    
        interface ILookup
        {
            public function get($key, $default = null);
            public function exists($context, $key);
        }

2. Create the protocol implementing the interface

        class Lookup extends \Clj\AProtocol
        {
            public function get($object, $key, $default = null)
            {
                return $this->__getObject__($object)->get($object, $key, $default);
            }
            public function exists($object, $key)
            {
                return $this->__getObject__($object)->exists($object, $key);
            }
        } 

    the \_\_getObject\_\_ method finds the objects type and returns the concrete implementation
    of the protocol

3. Create the concrete implementations of the protocol (in my code I have the type name of the 
implementation prefixed by a P (i.e. PNull for a null or PDateTime for a DateTime object)
    
        class PArray extends \Clj\AProtocolInstance implements ILookup //Lookup for arrays
        {
            public function get($context, $key, $default = null)
            {
                if (isset($context[$key]) || (array_key_exists($key, $context)))
                {
                    return $context[$key];
                }
                return $default;
            }

            public function exists($context, $key)
            {
                return (isset($context[$key]) || (array_key_exists($key, $context)));
            }
        }

        class PNull extends \Clj\AProtocolInstance implements ILookup //Lookup for null
        {
            public function get($context, $key, $default = null)
            {
                return $default;
            }

            public function exists($context, $key)
            {
                return false;
            }
        }

##Using the Protocol manager

Protocols are created and extended using the Protocol manager class.  To add a protocol
you pass in a protocol object
    
    $lookup = new Lookup();
    $protocol_manager->add($lookup);

To add types to the protocol you can use either the extendType or extendProtocol methods

    //Extends a type to an array of protocols
    $protocol_manager->extendType(\Clj\IProtocol::PROTOCOL_NULL, array('ILookup' => new PNull()));
    //Extends the protocol to an array of types
    $protocol_manager->extendProtocol('ILookup', array(\Clj\IProtocol::PROTOCOL_NULL => new PNull(),
        \Clj\IProtocol::PROTOCOL_ARRAY => new PArray()));

For retrieving the extended protocols you can use either getProtocol or getProtocolReference.
Here's an example of how they are used
    

    $lookup = new Lookup();
    $protocol_manager->add($lookup);

    $protocol_manager->extendType(\Clj\IProtocol::PROTOCOL_NULL, array('ILookup' => new PNull()));
    //Gets the lookup protocol that only works for null types
    $extended_lookup = $protocol_manager->getProtocol('ILookup');
    $lookup_reference = $protocol_manager->getProtocolReference('ILookup');

    $protocol_manager->extendType(\Clj\IProtocol::PROTOCOL_ARRAY, array('ILookup' => new PArray()));

    $extended_lookup->get(null, 'foo', 'bar'); //Returns 'bar'
    $extended_lookup->get(array('foo' => 'bar'), 'foo', 'bar'); //Throws excpetion

    $lookup_reference->getRef()->get(null, 'foo', 'bar'); //Returns 'bar'
    $lookup_reference->getRef()->get(array('foo' => 'BAZ'), 'foo', 'bar'); //Returns 'BAZ'

In the example getProtocol returns the lookup protocol as it exists at the time it was called (only 
extended for the null type).  Any extensions of the protocol done later on (extending the lookup 
protocol to arrays) are not added to `$extended_lookup`.

In contrast getProtocolReference returns a reference to a protocol similar to `$a =& $b` only this 
reference is read only and accessed by the getRef method.  This allows access to all the extensions
of the protocol not just the ones that existed when the reference was created.
