<?php
/**
 * Created by PhpStorm.
 * User: mrunkel
 * Date: 2/8/15
 * Time: 12:05 PM
 */


/**
 * This function generates a password salt as a string of x (default = 15) characters
 * in the a-zA-Z0-9!@#$%&*? range.
 * @param $max integer The number of characters in the string
 * @return string
 * @author AfroSoft <info@afrosoft.tk>
 */
function generateSalt($max = 15)
{
    $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
    $i = 0;
    $salt = "";
    while ($i < $max) {
        $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        $i++;
    }
    return $salt;
}

// force redirec to https
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'Off') {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: https://' . $_SERVER['HTTP_HOST']  $_SERVER['REQUEST_URI']);
    exit;
}

if (empty($_REQUEST['passwd']) || $_REQUEST['passwd'] == "" || $_REQUEST['passwd'] != $_REQUEST['passwd2']) {
    // the display the input form.

    if ($_REQUEST['passwd'] == "" && !empty($_REQUEST['passwd'])) {
        echo "<BR>Password was empty!<BR>";
    }

    if ($_REQUEST['passwd'] != $_REQUEST['passwd2']) {
        echo "<BR>Passwords didn't match!<BR>";
    }
    ?>
    <BR>
    Submit the password you'd like to hash. Don't worry, we don't store the password except for the
    few milliseconds that we're hashing it.   You'll need to email the output of the hash yourself.
    <BR>
    <HR>
    <form method="post" id="wp-test-form">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label for="passwd">Enter the password to hash:</label>
                </th>
                <td>
                    <input name="passwd" id="passwd" type="password">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="passwd2">Reenter the password to hash:</label>
                </th>
                <td>
                    <input name="passwd2" id="passwd2" type="password">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="salt">Optional - enter a salt:</label>
                </th>
                <td>
                    <input name="salt" id="salt" type="text">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Note: Entering a manual salt is not recommended, as the system will generate a good one for
                        you.</strong>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
            <input type="submit" name="submit" value="Submit" class="button-primary"/>
        </div>
    </form>
<?php
} else {
    // display the result
    if (empty($_REQUEST['salt']) || $_REQUEST['salt'] == "") {
        $salt = generateSalt();
    } else {
        $salt = $_REQUEST['salt'];
    }
    $hash = crypt($_REQUEST['passwd'], '$6$' . $salt);
    $mysql = strtoupper(sha1(sha1($_REQUEST['passwd'], true)));
    ?>
    <br>
    <P>The resulting hash (including the salt) is: <br><BR><?php echo $hash; ?><br><br> Please email this to the person
        that requested the hash.</P>

    <P>
        Note: Running this script multiple times without specifying a salt will result in different results. This is
        because the randomly
        generated salt (<?php echo $salt; ?>) will change each time. However that doesn't matter. What matters is that
        in
        the future
        when you type in your password, the system is able to take your password, perform the same hash on it
        with the salt stored in the output above, and that the result matches the above output..
    </P>
    <P> Bonus: Here is the mysql compatible hash of the same password: <?php echo $mysql; ?></P>
<?php
}
