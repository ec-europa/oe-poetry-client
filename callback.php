<?php
/**
 * @file
 * Callback file.
 */
use EC\Poetry\Poetry;

/**
 * Callback defined in Poetry WSDL.
 *
 * This value is hardcoded on the service side and must be available in the
 * global namespace.
 *
 * @param string $user
 * @param string $password
 * @param string $msg
 *
 * @return string
 *    Response in plain XML.
 */
function FPFISPoetryIntegrationRequest($user, $password, $msg)
{
    $callback = Poetry::getInstance()->raw('server.callback');
    $response = $callback($user, $password, $msg);
    Poetry::getInstance()->getServer()->setResponse($response);

    return  $response;
}
