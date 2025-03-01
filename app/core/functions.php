<?php
# display input
function show($stuff)
{
    echo"<pre>";
    print_r($stuff);
    echo"</pre>";
}

# removes html special characters
function esc($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function redirect($path)
{
    header("Location: " .ROOT ."/".$path);
    exit;
}

?>