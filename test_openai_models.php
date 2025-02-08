<?php
require 'vendor/autoload.php';
use OpenAI\Client;
use Dotenv\Dotenv;

// Load API key from .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;

if (!$apiKey) {
    die("API Key is missing. Please check your .env file.");
}

// Create OpenAI client
$client = OpenAI::client($apiKey);

// Get available models
$response = $client->models()->list();
echo "<pre>";
print_r($response);
echo "</pre>";
?>
