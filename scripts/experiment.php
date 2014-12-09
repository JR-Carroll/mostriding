<html>
<head>
    <title>Test Script</title>
</head>
<body>
    <?php


    // A sampling of various print statements.  None of which do
    // anything special.
    print("This is a list of all the cars I've ever drive:");
    print("
    <ul>
        <li>Taurus</li>
        <li>Honda Civic</li>
        <li>yO Momma</li>
    </ul>");

    // This is the printf with signifiers in the fn() call.
    printf("My Values:
        <br/>0%0.2f
        <br/>0%0.2f
        <br/>%0.2f
        <br/>%0.2f<br/><br/>", 8.11, 2.22, 23.21, 22.00);

    // Making an array, just to make sure that I've done it!
    // Will also do some concatenation.

    $myArray = array("test", "test2", "test3");
    print("This is my first " . $myArray[0]) . ".  Hear me roar!";

    // Now I will test my dictionary call.
    print("<br/><br/>Here is my associative array (aka dictionary)<br/>");

    $myDict = array( "Dave" => "yoMomma",
                "Sam" => "Beezee",
                "Test" => "2"
              );

    print $myDict["Dave"];

    $array1 = array(
        "Smith"     => 1,
        "John"      => 13.2,
        "Fields"    => 15.2,
        "Bleh"      => 1.999
        );

    $array2 = array(
        "Bobby"     => 1,
        "Dean"      => 3,
        "Eric"      => 4,
        "Rick"      => 2
        );

    print("<table border=1>");

    $avgArray1      = null;

    foreach ($array1 as $name => $value) {
        printf("<br/><tr><td>%s</td><td>%0.2f</td></tr>", $name, $array1[$name]);
        $avgArray1 += $value;
    }

    $avg = $avgArray1/4;

    print("</table>");

    printf("<b>Total Avg: %.2f</b>", $avg);
    ?>


</body>
</html>
