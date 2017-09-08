<?php

require_once '../includes/functions.php';

if (is_admin() == false) {
    redirect_to('index.php');
}

/**
 * Password Hash Cost Calculator
 *
 * Set the ideal time that you want a password_hash() call to take and this
 * script will keep testing until it finds the ideal cost value and let you
 * know what to set it to when it has finished
 */
// Milliseconds that a hash should take (ideally)

$mSec = 100;
$password = 'admin';


echo "<h2>Password Hash Cost Calculator</h2>";
echo "Testing BCRYPT hashing the password '$password'";
echo "We're going to run until the time to generate the hash takes longer than {$mSec}ms";

if (isset($_POST['submit'])) {
    $cost = intval($_POST['costnum']);

    do {
        $cost++;
        echo "\nTesting cost value of $cost: ";
        $time = benchmark($password, $cost);
        echo "... took $time<br>";
    } while ($time < ($mSec/1000));
    echo "<em>Ideal cost is $cost</em><br>";
    echo "<br>>Running 100 times to check the average:<br>";
    $start = microtime(true);
    $times = [];
    for ($i=1; $i<=100; $i++) {
        echo "$i/100<br>";
        $times[] = benchmark($password, $cost);
    }
    echo "done benchmarking in ".(microtime(true)-$start)."<br>>";
    echo "<br>Slowest time: ".max($times);
    echo "<br>Fastest time: ".min($times);
    echo "<br>Average time: ".(array_sum($times)/count($times));
    echo "Finished<br>";

}
?>

<form action="" method="post">
    <label for="costnumber">Costnumber
        <input name="costnum" type="number">
    </label>
    <button type="submit" name="submit">Submit</button>
</form>
