<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
       
		$request->validate([
			'question' => 'required',
		]);
		
		$question = $request->question;

		$response = OpenAi::chat()->create([
			'model' => 'gpt-3.5-turbo',
			'messages' => [
				['role' => 'user', 'content' => $question],
			],
		]);

		$answer = trim($response['choices'][0]['message']['content']);

		return response()->json(['question' => $question, 'answer' => $answer]);

	
    }
}
