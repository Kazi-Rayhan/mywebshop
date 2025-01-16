<?php

namespace App\Http\Controllers\Voyager;

use App\Http\Controllers\Controller;
use App\Imports\LanguageImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Imports\ShopsImport;
use Error;
use Exception;

class ImportsController extends Controller
{
    public function import_product(Request $request)
    {
        // Validate request
        $request->validate([
            'sheet' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
        //store sheet
        $sheet = $request->sheet->store('/uploads/sheets');
        $shop = $request->shop_id;

        try {
            Excel::import(new ProductsImport($shop), $sheet);
            Storage::delete($sheet);
            return back()->with([
                'message'    => 'Your product is being imported in background please wait couple a miniute',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {

            return redirect()->back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        } catch (Error $e) {

            return redirect()->back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function import_shops(Request $request)
    {
        // Validate request
        $request->validate([
            'sheet' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
        //store sheet
        $sheet = $request->sheet->store('/uploads/sheets');

        try {
            Excel::import(new ShopsImport, $sheet);
            Storage::delete($sheet);
            return back()->with([
                'message'    => 'Imported successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {

            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        } catch (Error $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function import_languages(Request $request)
    {
        try {
            $request->validate(['sheet' => 'required']);
            Excel::import(new LanguageImport, $request->sheet);
            return back()->with([
                'message'    => 'Imported successfully',
                'alert-type' => 'success',
            ]);
        } catch (Error $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        } catch (Exception $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }
}
