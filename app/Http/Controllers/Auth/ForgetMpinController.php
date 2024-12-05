<?PHP 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ForgetMpinController extends Controller
{
    /**
     * Check if the email exists.
     */
    public function checkEmail(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email', // Validate if email exists in the users table
            ], [
                'email.exists' => 'The email does not match our records.', // Custom error message
            ]);

            return response()->json([
                'message' => 'Email exists in the system.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors()['email'][0], // Extract the first error message for 'email'
            ], 401);
        }
    }

    /**
     * Reset MPIN with email.
     */
    public function resetMPIN(Request $request)
    {
        // Validate the request for new MPIN
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure email exists in the users table
            'new_mpin' => 'required|numeric|digits:4', // Ensure new MPIN is a 4-digit numeric value
        ]);

        try {
            // Find the user by email
            $user = User::where('email', $validatedData['email'])->firstOrFail();

            // Update the user's MPIN
            $user->update([
                'mpin' => $validatedData['new_mpin'], // Update the MPIN in the database
            ]);

            return response()->json([
                'message' => 'MPIN reset successfully.',
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error resetting MPIN: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while resetting the MPIN.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
