<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Participants as Participant;

class ParticipantController extends Controller
{
    public function index($id_company)
    {
        $check_company = DB::table('companies')->where('id_company', $id_company)->count();
      
        if($check_company == 0){
            return ['text' => 'Empresa não localizada'];
        }
      
        $participants_check = Participant::where('id_company', $id_company)->count();

        if($participants_check == 0){
            return ['text' => 'Nenhum participante cadastrado para esta empresa'];
        }else{

            $participants = Participant::where('id_company', $id_company)->get();
            return $participants;
        }
      
    }

    public function store(Request $request, $id_company)
    {
        $check_company = DB::table('companies')->where('id_company', $id_company)->count();
      
        if($check_company == 0){
            return ['text' => 'Empresa não localizada'];
        }

        $taxid = $request->input('taxid');
        $name = $request->input('name');
        $mail = $request->input('mail');
        $birthday = format_date_to_db($request->input('birthday'));
 
        if(!taxid_verify($taxid)){
            return ['text' => 'CPF inválido'];
        }

        if(!mail_verify($mail)){
            return ['text' => 'E-mail inválido'];
        }

        if(!$name){
            return ['text' => 'O campo nome é obrigatório'];
        }

        if(!$birthday){
            return ['text' => 'O data de nascimento é obrigatório'];
        }

        $taxid = preg_replace( '/[^0-9]/is', '', $taxid );

        $participants_check = Participant::where('id_company', $id_company)->where('taxid', $taxid)->count();

        if($participants_check > 0){
            return ['text' => 'CPF do participante já cadastrado para esta empresa'];
        }else{
            $participant = new Participant;

            $participant->id_company = $id_company;
            $participant->taxid = $taxid;
            $participant->name = $name;
            $participant->mail = $mail;
            $participant->birthday = $birthday;
    
            $participant->save();

            return ['text' => 'Participante cadastrado com sucesso'];
        }

    }

    public function show($id_company, $id)
    {
        $check_company = DB::table('companies')->where('id_company', $id_company)->count();
      
        if($check_company == 0){
            return ['text' => 'Empresa não localizada'];
        }


        $get_company = Participant::where('id_participant', $id)->count();

        if($get_company == 0){
            return ['text '=> 'Participante não localizado'];
        }else{
            
            $participant = DB::table('participants')->join('companies', 'companies.id_company', '=', 'participants.id_company')->where('id_participant', $id)->get();

           return $participant;
        }
    }

    public function update(Request $request, $id_company, $id)
    {
        $check_company = DB::table('companies')->where('id_company', $id_company)->count();
      
        if($check_company == 0){
            return ['text' => 'Empresa não localizada'];
        }

        $get_company = Participant::where('id_participant', $id)->count();

        if($get_company == 0){
            return ['text '=> 'Participante não localizado'];
        }else{

            $taxid = $request->input('taxid');
            $name = $request->input('name');
            $mail = $request->input('mail');
            $birthday = format_date_to_db($request->input('birthday'));

            if($mail){
                if(!mail_verify($mail)){
                    return ['text' => 'E-mail inválido'];
                }
            }
    
            $taxid = preg_replace( '/[^0-9]/is', '', $taxid );

            if($taxid){
                if(!taxid_verify($taxid)){
                    return ['text' => 'CPF inválido'];
                }
        
                //Verifica cpf do participante
                $participants_check = Participant::where('id_company', $id_company)->where('taxid', $taxid)->count();

                if($participants_check > 0){
                    return ['text' => 'CPF do participante já cadastrado para esta empresa'];
                }else{
                    $array_update = Array();
                    if($name){
                        $array_update['name'] = $name;
                    }
                    
                    if($mail){
                        $array_update['mail'] = $mail;
                    }
                    
                    if($birthday){
                        $array_update['birthday'] = $birthday;
                    }

                    if($taxid){
                        $array_update['taxid'] = $taxid;
                    }

                    $participant = Participant::where('id_participant', $id)->update($array_update);
                    return ['text' => 'Participante atualizado com sucesso'];
                }
            }else{
                $array_update = Array();
                if($name){
                    $array_update['name'] = $name;
                }
                
                if($mail){
                    $array_update['mail'] = $mail;
                }
                
                if($birthday){
                    $array_update['birthday'] = $birthday;
                }

                $participant = Participant::where('id_participant', $id)->update($array_update);
                return ['text' => 'Participante atualizado com sucesso'];
            }
        }
    }

    public function destroy($id_company, $id)
    {
        $check_company = DB::table('companies')->where('id_company', $id_company)->count();
      
        if($check_company == 0){
            return ['text' => 'Empresa não localizada'];
        }

        $get_company = Participant::where('id_participant', $id)->count();

        if($get_company == 0){
            return ['text '=> 'Participante não localizado'];
        }else{
            $company = Participant::where('id_participant', $id)->delete();
            return ['text' => 'Participante foi excluído com sucesso'];
        }
    }
}
