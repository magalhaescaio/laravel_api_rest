<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies as Company;

class CompanyController extends Controller
{
   public function index()
    {
        $rows = Company::all();
        $total = $rows->count();

       if($total == 0){
            return ['text' => 'Nenhum resultado'];
       }else{
            return $rows;
       }
    }
 
    public function store(Request $request)
    {
        $company_name = $request->input('company_name');
        $corporate_tax_code = $request->input('corporate_tax_code');

        if(!corporate_tax_code_verify($corporate_tax_code)){
            return ['text' => 'CNPJ inválido'];
        }

        if(!$company_name){
            return ['text '=> 'Nome da empresa é obrigatório']; 
        }

        $corporate_tax_code = preg_replace('/[^0-9]/', '', (string) $corporate_tax_code);

        $company_check = Company::where('corporate_tax_code', $corporate_tax_code)->count();

        if($company_check > 0){
            return ['text '=> 'Este CNPJ já foi cadastrado'];
        }else{
            $company = new Company;

            $company->company_name = $company_name;
            $company->corporate_tax_code = $corporate_tax_code;
    
            $company->save();
    
            return ['text' => 'Empresa cadastrada com sucesso'];
    
        }
    }

    public function show($id)
    {
        $get_company = Company::where('id_company', $id)->count();

        if($get_company == 0){
            return ['text '=> 'Empresa não localizada'];
        }else{
            $get_company = Company::where('id_company', $id)->firstOrFail();

            return $get_company;
        }
    }

    public function update(Request $request, $id)
    {
        $company_name = $request->input('company_name');
        $corporate_tax_code = $request->input('corporate_tax_code');
        
        $corporate_tax_code = preg_replace('/[^0-9]/', '', (string) $corporate_tax_code);
        
        if(!$company_name && !$corporate_tax_code){
            return ['text '=> 'Nenhuma parâmetro foi localizado, verifique os dados informados'];
        }

        if($corporate_tax_code){
            if(!corporate_tax_code_verify($corporate_tax_code)){
                return ['text' => 'CNPJ inválido'];
            }
            //Verificar se cnpj ja esta cadastrado
            $company_check = Company::where('corporate_tax_code', $corporate_tax_code)->count();

            if($company_check > 0){
                if($company_name){
                    $company = Company::where('id_company', $id)->update(['company_name' => $company_name]);
                    return ['text' => 'Empresa atualizada com sucesso'];
                }else{
                    return ['text '=> 'Este CNPJ já foi cadastrado'];
                }
            }else{
                $array_update = Array();
                if($company_name){
                    $array_update['company_name'] = $company_name;
                }

                if($corporate_tax_code){
                    $array_update['corporate_tax_code'] = $corporate_tax_code;
                }

                $company = Company::where('id_company', $id)->update($array_update);

                return ['text' => 'Empresa atualizada com sucesso'];
            }

        }else{
            $company = Company::where('id_company', $id)->update(['company_name' => $company_name]);
            return ['text' => 'Empresa atualizada com sucesso'];
        }      
    }

    public function destroy($id)
    {
        $get_company = Company::where('id_company', $id)->count();

        if($get_company == 0){
            return ['text '=> 'Empresa não localizada'];
        }else{
            $company = Company::where('id_company', $id)->delete();
            return ['text' => 'Empresa foi excluída com sucesso'];
        }
    }
}
