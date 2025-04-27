public function paymentHistory()
{
    return view('parent.payments', [
        'payments' => auth()->user()->payments()->with('booking')->get()
    ]);
}