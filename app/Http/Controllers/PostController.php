<?php

namespace App\Http\Controllers;

use App\Models\RepositorySQL\PostRepositorySQL;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostRepositorySQL $postrepo;
   public function __construct(PostRepositorySQL $postrepo) {
    $this->postrepo=$postrepo;
   }
    public function getPosts(){
        return $this->postrepo->getAllSql();
    }
    public function getByIdPost($Id){
        $postId= $this->postrepo->getByIdSql($Id);
        if (!$postId) {
            return response()->json(['message' => ''], 404);
        }
        return response()->json($postId);
    }
    public function AddPostSql(Request $request){
        $validation=$request->validate([
            "title"=>"required",
            "content"=>"required",
            "UserId"=>"required"
        ]);
        $added=$this->postrepo->AddSql($validation);
        if ($added) {
            return response()->json([
                'message' => 'post added successfully.',
                'post' => $added
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to add post.'
            ], 500);
        }
    }

    public function UpdatePostSql(Request $request, $Id)
{
    $column = $request->input("column");
    $data = $request->input("data");

    if (!$column || !$data) {
        return response()->json([
            'success' => false,
            'message' => 'يجب إرسال اسم العمود والقيمة المطلوب تحديثها.'
        ], 400);
    }
    $allowedColumns = ['title', 'content'];
    if (!in_array($column, $allowedColumns)) {
        return response()->json([
            'success' => false,
            'message' => 'العمود المحدد غير مسموح بتعديله.'
        ], 400);
    }
    $updated = $this->postrepo->UpdateSql($Id, $column, $data);

    return response()->json([
        'success' => (bool) $updated,
        'message' => $updated ? 'تم تحديث البيانات بنجاح' : 'فشل التحديث أو لم يتم العثور على السجل'
    ]);
}

}
