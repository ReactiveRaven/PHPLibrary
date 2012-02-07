This library is presented as a collection of useful tools.


The use of the included autoloader is recommended:

    require (".../RRaven/Autoloader.php");
    new RRaven_Autoloader()


Code contributions are welcomed:
http://github.com/ReactiveRaven/PHPLibrary

#RRaven\_Array
An object-oriented array, exposing common array manipulation functions in a sensible way.

Note that `RRaven_Array` uses boolean method names for clarity, eg: "and not" rather than "array_diff".

#RRaven\_Color
A colour object for converting between and altering RGB, HSL and Hex colour formats.

    // magenta = #FF00FF = rgb(255,0,255) = hsl(0.83, 1, 0.5)
    
    $pink = RRaven_Color::fromHex("#FF00FF")->setBlue(0)->setSaturation(0.5);
    $red = RRaven_Color::fromRGB(array(255, 0, 255))->setHue(0);
    $grey = RRaven_Color::fromHSL(array(0.83, 1, 0.5))->setSaturation(0);

#RRaven\_Stream\_
A set of stream manipulation classes for use in processing large files with low memory overhead.

`RRaven_Stream_Transform_` classes implement `RRaven_Stream_Reader_Abstract` so a chain formed of multiple transforms 
can be constructed between a reader and a writer.

Note also that `RRaven_Stream_Reader_` classes implement Traversable, so can be looped over in a foreach loop as 
though they were a normal array.

#RRaven\_Render\_Exception
Renders an exception object in a human-readable colour-coded HTML format, pulling in code-snippets where possible.