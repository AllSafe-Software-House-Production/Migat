<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Resources\Admin\FaqResource;
use App\Http\Traits\UserResponseTrait;
use App\Models\FAQ;

class FaqController extends Controller
{
    use UserResponseTrait;

    public function index()
    {
        $faqs = FAQ::latest()->paginate(10);
        return $this->success([
            'faqs' => FaqResource::collection($faqs),
            'pagination' => [
                'total' => $faqs->total(),
                'per_page' => $faqs->perPage(),
                'current_page' => $faqs->currentPage(),
                'last_page' => $faqs->lastPage(),
            ]
        ], 'All FAQs');
    }

    public function store(FaqRequest $request)
    {
        $faq = FAQ::create($request->validated());
        return $this->success(new FaqResource($faq), 'FAQ created successfully');
    }

    public function show($id)
    {
        $faq = FAQ::findOrFail($id);
        if (! $faq) return $this->fail('FAQ not found', 404);
        return $this->success(new FaqResource($faq), 'FAQ fetched');
    }

    public function update(FaqRequest $request, $id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->update($request->validated());
        return $this->success(new FaqResource($faq), 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        if (! $faq) return $this->fail('FAQ not found', 404);
        $faq->delete();
        return $this->success(null, 'FAQ deleted successfully');
    }
}