<?php
if(isset($_REQUEST["file"]))
{
    // Get parameters
    $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string

    /* Check if the file name includes illegal characters
    like "../" using the regular expression */
    if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file))
	{
        $filepath = "AvatarSVGs/" . $file;
        if(file_exists($filepath))
		{
            echo md5_file(
                $filepath
            );

            die();
        } else
		{
            http_response_code(404);
	        die();
        }
    } else
	{
        die("Invalid file name!");
    }
}
?>