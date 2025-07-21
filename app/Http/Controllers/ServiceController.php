<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return response()->json(['data' => $services], 200);
    }

    public function store(ServiceRequest $request) {
        $data = $request->validated();

        $service = Service::create($data);

        return response()->json(['message' => 'تم إضافة الخدمة بنجاح.'], 200);
    }

    public function show(int $id) {
        $service = Service::findOrFail($id);

        return response()->json(['data' => $service], 200);
    }

    public function update(int $id, ServiceRequest $request) {
        $data = $request->validated();

        $service = Service::findOrFail($id);

        $service->update($data);

        return response()->json(['data' => $service, 'message' => 'تم تعديل بيانات الخدمة بنجاح.'], 200);
    }

    public function destroy(int $id) {
        Service::destroy($id);

        return response()->json(['message' => 'تم حذف الخدمة بنجاح.']);
    }
}
