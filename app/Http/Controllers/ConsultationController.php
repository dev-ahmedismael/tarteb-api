<?php

namespace App\Http\Controllers;


use App\Http\Requests\ConsultationRequest;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request) {
        $consultations = Consultation::latest()->paginate(50);

        return response()->json(['data' => $consultations]);
    }

    public function store(ConsultationRequest $request) {
        $data = $request->validated();

        Consultation::create($data);

        return response()->json([
            'message' => 'تم إرسال الإستشارة بنجاح وسيتم التواصل معكم خلال 24 ساعة.'
            ],201);
    }

    public function show(int $id) {
        $consultation = Consultation::findOrFail($id);

        return response()->json(['data' => $consultation]);
    }

    public function update(Request $request, int $id) {
        $is_seen = $request->only('is_seen');

        $consultation = Consultation::findOrFail($id);

        $consultation->update($is_seen);

        return response()->json(['data' => $consultation]);
    }

    public function destroy(int $id)
    {
        Consultation::destroy($id);

        return response()->json(['message' => 'تم حذف الإستشارة بنجاح.']);
    }
}
