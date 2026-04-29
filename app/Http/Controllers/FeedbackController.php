<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // list all feedbacks
    public function index()
    {
        //
        $feedbacks = Feedback::all();
        return response()->json($feedbacks);
    }

    // submit a new feedback
    public function submitFeedback(Request $request)
    {
        //
        $user = $request->user();

        $fields = $request->validate([
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'comment' => ['required', 'string'],
            'recipient_id' => ['required', 'exists:users,id'],
        ]);

        if ($user->id === $fields['recipient_id']) {
            return response()->json(['error' => 'Author and recipient cannot be the same'], 400);
        }

        $recipient = User::findOrFail($fields['recipient_id']);

        if ($recipient->isProvider() && $user->isProvider()) {
            return response()->json(['error' => 'Providers cannot give feedback to other providers'], 400);
        }

        if ($recipient->isRenter() && $user->isRenter()) {
            return response()->json(['error' => 'Renters cannot give feedback to other renters'], 400);
        }

        $feedback = Feedback::create([
            'rating' => $fields['rating'],
            'comment' => $fields['comment'],
            'author_id' => $user->id,
            'recipient_id' => $fields['recipient_id'],
        ]);

        return response()->json($feedback, 201);
    }

    // show a specific feedback
    public function showFeedback(string $id)
    {
        //
        $feedback = Feedback::findOrFail($id);

        return response()->json($feedback);
    }

    // edit a specific feedback
    public function editFeedback(Request $request, string $id)
    {
        //
        $user = $request->user();

        $feedback = Feedback::findOrFail($id);

        if ($user->id !== $feedback->author_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'rating' => ['numeric', 'min:0', 'max:5'],
            'comment' => ['string'],
        ]);

        $feedback->update($fields);

        return response()->json($feedback);
    }

    // delete a specific feedback
    public function deleteFeedback(string $id)
    {
        //
        $feedback = Feedback::findOrFail($id);

        $feedback->delete();

        return response()->json(null, 204);
    }

    
    // Display the feedbacks of a specific recipient.
    public function recipientFeedbacks(string $id)
    {
        $feedbacks = Feedback::where('recipient_id', $id)->get();

        return response()->json($feedbacks);
    }

    // Display the feedbacks of a specific author.
    public function authorFeedbacks(string $id)
    {
        $feedbacks = Feedback::where('author_id', $id)->get();

        return response()->json($feedbacks);
    }

    public function getRecipientAverageRating(string $recipientId)
    {
        $averageRating = Feedback::averageRatingForRecipient($recipientId);

        return response()->json($averageRating, 200);
    }

}
