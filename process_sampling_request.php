<?php
session_start();
include('db_connect.php');
require 'vendor/autoload.php'; // Load Composer dependencies

use Dotenv\Dotenv;
use OpenAI\Client;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Retrieve API key from .env file
$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;

if (!$apiKey) {
    die("Fatal Error: OpenAI API Key is missing. Please check your .env file.");
}

// Create OpenAI client
$client = OpenAI::client($apiKey);

if (!isset($_GET['file'])) {
    die("No file specified.");
}

$file_path = urldecode($_GET['file']);

// Convert Image/PDF to Text (Use OCR)
$text = ocr_extract_text($file_path);

// Translate Text to English
$translated_text = translate_to_english($text);

// Extract Event Information Using AI
$event_details = extract_event_details($translated_text);

if ($event_details) {
    // Insert event into the database
    $stmt = $conn->prepare("INSERT INTO events (event_name, event_date, event_time, event_duration, sampling_count, contact_person, contact_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", 
        $event_details['event_name'], 
        $event_details['event_date'], 
        $event_details['event_time'], 
        $event_details['event_duration'], 
        $event_details['sampling_count'], 
        $event_details['contact_person'], 
        $event_details['contact_phone']
    );
    $stmt->execute();
    $stmt->close();

    echo "Event Created Successfully!";
} else {
    echo "Failed to extract event details.";
}

// OCR Function to Extract Text from PDF/Image
function ocr_extract_text($file_path) {
    return "Sample OCR Extracted Text"; // Placeholder, integrate with OCR library
}

// Translate Text to English Using OpenAI API
function translate_to_english($text) {
    global $client;
    $response = $client->completions()->create([
        'model' => 'gpt-3.5-turbo', // Use updated model
        'prompt' => "Translate this to English: $text",
        'max_tokens' => 100,
    ]);
    return trim($response['choices'][0]['text']);
}

// Extract Event Details Using OpenAI API
function extract_event_details($text) {
    global $client;
    $response = $client->completions()->create([
        'model' => 'gpt-3.5-turbo', // Use updated model
        'prompt' => "Extract event details from this text:\n\n$text\n\nProvide output as JSON with fields: event_name, event_date, event_time, event_duration, sampling_count, contact_person, contact_phone.",
        'max_tokens' => 150,
    ]);
    
    return json_decode($response['choices'][0]['text'], true);
}
?>
