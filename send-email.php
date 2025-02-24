<?php
require 'vendor/autoload.php';
use Resend;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
# Check environment variables
if (!isset($_ENV['RESEND_API_KEY']) && !isset($_ENV['RESEND_EMAIL_FROM']) && !isset($_ENV['RESEND_EMAIL_TO'])) {
  response('error', 'Missing environment variables');
}
# Set constants
define('RESEND_API_KEY', $_ENV['RESEND_API_KEY']);
define('RESEND_EMAIL_FROM', $_ENV['RESEND_EMAIL_FROM']);
define('RESEND_EMAIL_TO', $_ENV['RESEND_EMAIL_TO']);
define('FRONTEND_URL', $_ENV['FRONTEND_URL']);
# Set CORS headers
header("Access-Control-Allow-Origin:". FRONTEND_URL);
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Allow-Headers: Content-Type");
# Check if the request origin is allowed
if (isset($_SERVER['HTTP_ORIGIN'])) {
  if ($_SERVER['HTTP_ORIGIN'] !== FRONTEND_URL) {
    response('error', 'Access denied (Invalid Origin)');
  }
} else {
    response('error', 'No Origin header present');
}
# Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  response('error', 'Invalid request method');
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
# Validate data received from the form
function validateData($name, $email, $message)
{
  if (empty($name) || empty($email) || empty($message)) {
    response('error', 'All fields are required');
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Invalid email');
  }
  if (strlen($name) > 100 || strlen($name) < 3 || strlen($email) > 100 || strlen($message) > 2000 || strlen($message) < 3) {
    response('error', 'Invalid name, email or message');
  }
}
# Send email using Resend
function sendEmail($name, $email, $message)
{
  try {
    $resend = Resend::client(RESEND_API_KEY);
    $resend->emails->send([
      'from' => RESEND_EMAIL_FROM,
      'to' => RESEND_EMAIL_TO,
      'subject' => 'Mensaje de: ' . $name,
      'html' => '<p>' . $message . '</p><p>' . $email . '</p>'
    ]);
    response('success', 'Email sent successfully');
  } catch (Exception $e) {
      response('error', 'Error sending email ' . $e->getMessage());
  }
}
# Return response
function response($status, $data)
{
  die(json_encode([$status => $data]));
}

validateData($name, $email, $message);
sendEmail($name, $email, $message);