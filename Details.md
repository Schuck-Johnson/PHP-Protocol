#Details

##What is a Protocol
A protocol is a way of implementing abstractions (i.e. interfaces) on classes / objects 
without modifying the original classes / objects (no wrappers or monkey patching).
Protocols are similar to interfaces, defining methods and parameters and having the invocation
of a method depend on the type, only the invoking object is an explicit parameter (the first 
parameter of the method)

Here's a demonstration of the difference using two interfaces for a image file object
    
    interface Image
    {
        public function resize($width, $height);
    }

    interface File
    {
        public function save($width, $height);
    }

How the methods are access normally (with the invoking object being the implicit $this)

    $image_object->resize(100, 100);
    $image_object->save();

How they are accessed using protocols (with the invoking object as the first parameter)

    $image_protocol->resize($image_object, 100, 00);
    $file_protocol->save($image_object);

Here's the pseudo code for how this works

    //High level
    $return_value $protocol->method($object, $param1, $param2, $paramN);
    //Low level details
    $object_type = $protocol->findTheTypeOfTheObject($object);
    
    $concrete_implementation = $protocol->getConcreteImplentation($object_type);
    
    $return_value = $concrete_implementation->method($object, $param1, $param2, $paramN);

For more information see [here](http://www.ibm.com/developerworks/java/library/j-clojure-protocols/index.html), [here](http://jeditoolkit.com/2012/03/21/protocol-based-polymorphism.html), and [here](http://www.infoq.com/presentations/Clojure-Expression-Problem).


##Benefits

1. Separates out an objects state from it's behavior.

2. Allows base types like null, array, string to have methods.  For example you can have 
`$key_value = $lookup->get($object, $key, $defualt)` work equally well for PHP objects, arrays, 
or nulls or have a timestamp method for string `$timestamp->timestamp('2011-03-09');`

3. Allows the original class / object to be unmodified but have additional behavior added to it.
This is especially helpful for third party code you want to interact with your abstractions
but don't want to modify.

4. Greater reusability, since the behavior is not in the object a different object that has
all the needed protocols can be dropped into existing code without being modified.

5. Namespacing, if two interfaces have the same method name you can not implement them both.
With protocols those two methods live in separate namesapces.

##Drawbacks

1. More development work up front, the protocols need to be wired in and the appropriate protocols
for an object created instead of having all the methods be directly on the object.

1. Slower than direct object call, there is the type lookup, and the concrete implementation 
lookup that have to happen before the actual method call.
