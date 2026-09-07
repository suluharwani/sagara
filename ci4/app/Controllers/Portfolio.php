<?php

namespace App\Controllers;

use App\Models\MdlProduct;

class Portfolio extends BaseController
{
    public function index()
    {
        $model = new MdlProduct();
        $search = trim((string) $this->request->getGet('search'));

        $model->where('product_type', 'portfolio')
            ->where('deleted_at', null)
            ->where('status', 1)
            ->orderBy('created_at', 'DESC');

        if ($search !== '') {
            $model->groupStart()->like('nama', $search)->orLike('judul', $search)->groupEnd();
        }

        $data = [
            'portfolioItems' => $model->paginate(16),
            'pager' => $model->pager,
            'search' => $search,
        ];
        $data['content'] = view('home/content/portfolio', $data);

        return view('home/layout', $data);
    }
}
