<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $start_date = $request->input('start_date'); // ✅ Benar
        $end_date = $request->input('end_date');
        $status = $request->input('status');

        $query = Order::query()->with('konsumen');

        if ($start_date) {
            $query->whereDate('tanggal_order', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('tanggal_order', '<=', $end_date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->get();

        return view('admin.order.index', compact('orders'));
    }


    public function export(Request $request)
    {
        $query = Order::query()->with('konsumen');

        if ($request->start_date) {
            $query->whereDate('tanggal_order', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('tanggal_order', '<=', $request->end_date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        if ($request->format == 'excel') {
            return Excel::download(new \App\Exports\OrderExport($orders), 'order.xlsx');
        } elseif ($request->format == 'pdf') {
            $pdf = Pdf::loadView('admin.order.export-pdf', compact('orders'));
            return $pdf->download('order.pdf');
        }

        return redirect()->back();
    }


    public function show($id)
    {
        $order = Order::with(['konsumen', 'details.produk'])->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:belum bayar,sudah bayar,pesanan dikirim,selesai',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.order.index')->with('success', 'Status order diperbarui ke ' . ucfirst($request->status) . '.');
    }
}
