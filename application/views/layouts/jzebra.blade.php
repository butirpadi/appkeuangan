<applet name="jzebra" code="jzebra.PrintApplet.class" archive="{{ URL::to('packages/jzebra/jzebra.jar') }}" width="0" height="0">
    <!-- Optional, searches for printer with "zebra" in the name on load -->
    <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
    <param name="printer" value="{{ $appset->printeraddr }}">
    <!-- ALL OF THE CACHE OPTIONS HAVE BEEN REMOVED DUE TO A BUG WITH JAVA 7 UPDATE 25 -->
        <!-- Optional, these "cache_" params enable faster loading "caching" of the applet -->
    <!-- <param name="cache_option" value="plugin"> -->
    <!-- Change "cache_archive" to point to relative URL of jzebra.jar -->
    <!-- <param name="cache_archive" value="./jzebra.jar"> -->
    <!-- Change "cache_version" to reflect current jZebra version -->
    <!-- <param name="cache_version" value="1.4.9.1"> -->
 </applet>