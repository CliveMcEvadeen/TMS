<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Tenants;
use PDF; // Ensure Barryvdh\DomPDF\Facade\Pdf is imported

class PaymentController extends Controller
{
    /**
     * Display the payment history for the tenant.
     */
    public function index()
    {
        try {
            $payments = Payment::where('tenant_id', Auth::id())->get();
            return view('payments.index', compact('payments'));
        } catch (Exception $e) {
            Log::error("Error fetching tenant payments: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to retrieve payment history at this time.');
        }
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
{
    // Validate the form input (no need to validate 'payment_id' anymore)
    $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|string|in:credit_card,bank_transfer, mobile_money',
    ]);

    try {
        DB::beginTransaction();

        // Generate a 12-digit unique payment ID
        $payment_id = random_int(100000000000, 999999999999);

        // Ensure the payment ID is unique (unlikely collision, but double-check)
        while (Payment::where('payment_id', $payment_id)->exists()) {
            $payment_id = random_int(100000000000, 999999999999);
        }

        // Create a new payment
        $payment = new Payment();
        $payment->tenant_id = Auth::id();  // Assuming the authenticated user is the tenant
        $payment->payment_id = $payment_id;  // Set the unique 12-digit payment ID
        $payment->amount = $request->input('amount');
        $payment->payment_method = $request->input('payment_method');
        $payment->payment_status = 'pending';  // Set the initial status to 'pending'
        $payment->save();

        DB::commit();

        Log::info('Payment created successfully', ['payment_id' => $payment->payment_id, 'tenant_id' => Auth::id()]);
        return redirect()->back()->with('success', 'Payment submitted successfully and is pending approval.');

    } catch (Exception $e) {
        DB::rollBack();
        Log::error("Error creating payment: " . $e->getMessage(), [
            'tenant_id' => Auth::id(),
            'amount' => $request->input('amount')
        ]);
        return redirect()->back()->with('error', 'There was an error processing your payment.');
    }
}

    /**
     * Display all payments for the landlord.
     */
    public function landlordIndex()
    {
        try {
            $payments = Payment::with('tenant')->get();
            return view('landlord.payments.index', compact('payments'));
        } catch (Exception $e) {
            Log::error("Error fetching payments for landlord: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to retrieve payment information at this time.');
        }
    }

    /**
     * Approve a payment.
     */
    /**
 * Approve a payment.
 */
public function approve($id)
{
    try {
        $payment = Payment::findOrFail($id);

        if ($payment->payment_status != 'pending') {
            return redirect()->back()->with('error', 'Payment cannot be verified.');
        }

        $payment->payment_status = 'approved';
        $payment->approved_at = now(); // Set approval timestamp
        $payment->save();

        Log::info('Payment verified successfully', ['payment_id' => $payment->id]);
        return redirect()->back()->with('success', 'Payment verified successfully.');

    } catch (Exception $e) {
        Log::error("Error verifying payment: " . $e->getMessage(), ['payment_id' => $id]);
        return redirect()->back()->with('error', 'There was an error verifying the payment.');
    }
}


    /**
     * Reject a payment.
     */
    public function reject($id)
    {
        try {
            $payment = Payment::findOrFail($id);

            if ($payment->payment_status != 'pending') {
                return redirect()->back()->with('error', 'Payment cannot be rejected.');
            }

            $payment->payment_status = 'rejected';
            $payment->rejected_at = now(); // Set rejection timestamp
            $payment->save();

            Log::info('Payment rejected successfully', ['payment_id' => $payment->id]);
            return redirect()->back()->with('success', 'Payment rejected successfully.');

        } catch (Exception $e) {
            Log::error("Error rejecting payment: " . $e->getMessage(), ['payment_id' => $id]);
            return redirect()->back()->with('error', 'There was an error rejecting the payment.');
        }
    }

    /**
     * Find a specific payment by ID.
     */
    public function find_payment($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            return view('payments.show', compact('payment'));
        } catch (Exception $e) {
            Log::error("Error retrieving payment: " . $e->getMessage(), ['payment_id' => $id]);
            return redirect()->back()->with('error', 'Unable to retrieve the payment details.');
        }
    }

    public function viewReceipt($paymentId)
{
    try {
        // Retrieve the payment and ensure it's approved
        $payment = Payment::with('tenant')
            ->where('payment_id', $paymentId) // Ensure you're using the correct field
            ->where('payment_status', 'approved')
            ->firstOrFail(); // This will throw an exception if no results are found

        // Return the receipt view with the payment data
        return view('tenants.receipts', compact('payment')); // Note the change from 'receipts' to 'payment'
    } catch (ModelNotFoundException $e) {
        Log::error("Receipt not found for payment_id: $paymentId");
        return redirect()->back()->with('error', 'No receipt found for the specified payment ID.');
    } catch (Exception $e) {
        Log::error("Error retrieving receipt: " . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to retrieve receipt.');
    }
}


    

    public function generateReceipt($paymentId)
    {
        try {
            $payment = Payment::where('id', $paymentId)
                ->where('payment_status', 'approved')
                ->with('tenant')
                ->firstOrFail();
    
            $pdf = PDF::loadView('landlord.receipts.show', compact('payment'));
            return $pdf->download('receipt_' . $payment->payment_id . '.pdf');
    
        } catch (Exception $e) {
            Log::error("Error generating receipt PDF: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to generate receipt.');
        }
    }
    
    public function showReceipt($paymentId)
{
    try {
        Log::info("Attempting to retrieve receipt for payment ID: $paymentId");

        $payment = Payment::with('tenant')
            ->where('payment_id', $paymentId)
            ->where('payment_status', 'approved')
            ->firstOrFail();

        return view('tenants.receipts', compact('payment'));
    } catch (ModelNotFoundException $e) {
        Log::error("Receipt not found for payment_id: $paymentId");
        return redirect()->back()->with('error', 'No receipt found for the specified payment ID.');
    } catch (Exception $e) {
        Log::error("Error retrieving receipt: " . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to retrieve receipt.');
    }
}

}