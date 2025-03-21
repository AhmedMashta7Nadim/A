<?php

namespace App\Http\Controllers;

use App\Events\AlertEvent;
use App\Models\Commint;
use App\Models\RepositorySQL\CommintService;
use Illuminate\Http\Request;

class CommintController extends Controller
{
    private CommintService $commint_service;

    public function __construct(CommintService $commint_service)
    {
        $this->commint_service = $commint_service;
    }

    public function getCommint()
    {
        $select = $this->commint_service->getAllSql();
        //    broadcast(new AlertEvent("asd"));
        event(new AlertEvent("asd"));
        return $select;
    }
    public function sendAlert(Request $request)
    {
        event(new AlertEvent($request->message));

        return response()->json(['message' => 'Event broadcasted successfully']);
    }
    public function getCommintById($Id)
    {
        return $this->commint_service->getByIdSql($Id);
    }

    public function AddCommint(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'content' => 'required|string',
                'UserId' => 'required|integer|exists:users,id',
                'PostId' => 'required|integer|exists:posts,id',
            ]);

            // محاولة إضافة التعليق
            $commint = $this->commint_service->AddSql($validatedData);
            return response()->json([
                'message' => 'تم إضافة التعليق بنجاح',
                'commint' => $commint
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة التعليق',
                'error' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
    public function getCommintsinUser($id)
    {
        return $this->commint_service->getCommintWithUser($id);
    }
}
