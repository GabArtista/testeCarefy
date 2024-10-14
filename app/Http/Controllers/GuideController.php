<?php
// app/Http/Controllers/GuideController.php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class GuideController extends Controller
{
    /**
     * Display a listing of the hospitalizations.
     *
     * @return View|Factory|Response
     */
    public function index()
    {
        // Pega a data e horário atual
        $now = now();

        // Consulta todas as guias (internações) com o horário atual entre 'entry' e 'exit'
        $hospitalizations = Guide::with('patient')
            ->where('entry', '<=', $now) // Entrada deve ser menor ou igual ao horário atual
            ->where(function ($query) use ($now) {
                $query->where('exit', '>=', $now) // Saída deve ser maior ou igual ao horário atual
                    ->orWhereNull('exit'); // Ou saída pode ser nula (paciente ainda internado)
            })
            ->orderBy('entry', 'desc') // Ordena pela data de entrada
            ->get();

        // Retorna a view com as internações
        return view('admin.hospitalization', compact('hospitalizations'));
    }

    public function createWithPatient()
    {
        //dd('Método createWithPatient chamado!');
        return view('admin.hospitalization-create-with-patient');
    }

    // Método para listar todos os pacientes
    public function listPatients()
    {
        if (!auth()->check()) {
            return redirect()->route('login'); // Redireciona se não estiver autenticado
        }

        $patients = Patient::with(['user', 'guides'])->get(); // Usa all() para obter todos os registros
        //dd($patients->first()->getAttributes());

        return view('admin.hospitalization-list-patient-create', compact('patients'));
    }


    // Método para criar uma nova internação para um paciente existente
    public function createForPatient(User $patient)
    {
        return view('admin.hospitalization-create', compact('patient'));
    }

    // Método para criar uma nova internação junto com o cadastro de um novo paciente
    public function create()
    {
        return view('admin.hospitalization-create-with-patient');
    }

    // Método para visualizar detalhes da internação
    public function show($id)
    {
        // Busca a internação pelo ID
        $hospitalization = Guide::find($id);

        if (!$hospitalization) {
            abort(404, 'Internação não encontrada.');
        }

        // Retorna a view com os detalhes da internação
        return view('admin.hospitalization-show', compact('hospitalization'));
    }


    public function storeWithPatient(Request $request)
    {
        $validated = $request->validate([
            //     'name' => 'required|string|max:255',
            //     'birth' => 'required|date',
            //     'social_number' => 'required|string|max:14|unique:patients,social_number', // Corrigido para o campo correto
            //     'blood_type' => 'nullable|string',
            //     'description' => 'required|string',
            //     'entry' => 'required|date',
            //     'exit' => 'nullable|date|after_or_equal:entry',
        ]);

        $request['email'] = 'sem@email.com';
        try {
            // Cria o usuário
            $user = User::create([
                'name' => $request['name'],
                'email' => $request->input('email'),
                'password' => bcrypt('defaultpassword'), // ajuste conforme necessário
                'birth_date' => $request['birth_date'],
            ]);

            // Cria o paciente
            $patient = Patient::create([
                'user_id' => $user->id,
                'blood_type' => $request['blood_type'],
                'social_number' => $request['social_number'],
            ]);

            // Cria a internação
            $guide = Guide::create([
                'patient_id' => $patient->id,
                'description' => $request['description'],
                'entry' => $request['entry'],
                'exit' => $request['exit'],
            ]);

            return redirect()->route('hospitalization.index')->with('success', 'Paciente e internação criados com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar paciente e internação: ' . $e->getMessage());
        }
    }




    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'patient_id' => 'required|exists:patients,id', // Verifica se o patient_id existe na tabela patients
            'entry' => 'required|date', // Data de entrada deve ser uma data válida
            'exit' => 'nullable|date|after_or_equal:entry', // Data de saída deve ser opcional e deve ser após a entrada
            'description' => 'nullable|string|max:255', // Campo de descrição opcional
        ]);

        // Criação de uma nova internação
        $guide = new Guide();
        $guide->patient_id = $request->input('patient_id'); // ID do paciente
        $guide->entry = $request->input('entry'); // Data de entrada
        $guide->exit = $request->input('exit'); // Data de saída (pode ser nula)
        $guide->description = $request->input('description'); // Adiciona a descrição
        $guide->save(); // Salva no banco de dados

        // Redireciona para a lista de internações com uma mensagem de sucesso
        return redirect()->route('hospitalization.index')->with('success', 'Internação salva com sucesso!');
    }



    //Metodo que recebe os arquivos CSV
    public function csvimport()
    {
        $user = auth()->user();
        return view('admin.hospitalization-up-csv', compact('user'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ], [
            'csvFile.required' => 'O campo arquivo é obrigatório.',
            'csvFile.mimes' => 'Tipo inválido, só é aceito arquivo .CSV',
            'csvFile.max' => 'Tamanho do arquivo excede :max Mb.'
        ]);

        $headers = ['nome', 'nascimento', 'codigo', 'guia', 'entrada', 'saida'];
        $dataFile = file($request->file('csvFile'));
        $dataFile = array_slice($dataFile, 1);
        $csvData = array_map('str_getcsv', $dataFile);

        $arrayValues = [];
        foreach ($csvData as $keyData => $row) {
            foreach ($headers as $key => $header) {
                $arrayValues[$keyData]["var_$header"] = $row[$key];
            }
        }

        // Realizar a validação conforme as regras de negócio
        foreach ($arrayValues as $key => $row) {

            //dd($arrayValues);
            $nome = trim($row['var_nome']);
            $codigo = trim($row['var_codigo']);
            $guia = trim($row['var_guia']);
            $nascimento = trim($row['var_nascimento']);
            $entrada = trim($row['var_entrada']);
            $saida = trim($row['var_saida']);

            // try {
            //     // Certificar que a data esteja no formato esperado "d/m/Y"
            //     if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', trim($row['var_nascimento']))) {
            //         throw new \Exception('Formato de data inválido para o nascimento.');
            //     }

            //     $nascimento = Carbon::createFromFormat('d/m/Y', trim($row['var_nascimento']));

            //     if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', trim($row['var_entrada']))) {
            //         throw new \Exception('Formato de data inválido para a entrada.');
            //     }

            //     $entrada = Carbon::createFromFormat('d/m/Y', trim($row['var_entrada']));

            //     if (isset($row['var_saida']) && trim($row['var_saida']) !== '') {
            //         if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', trim($row['var_saida']))) {
            //             throw new \Exception('Formato de data inválido para a saída.');
            //         }
            //         $saida = Carbon::createFromFormat('d/m/Y', trim($row['var_saida']));
            //     } else {
            //         $saida = null;
            //     }
            // } catch (\Exception $e) {
            //     return back()->with('error', "Erro ao processar a data para o paciente {$nome}: " . $e->getMessage());
            // }


            // Validações das regras de negócio
            $isValid = true;
            $errorMessages = [];

            // RN02-01: Pacientes com mesmo NOME e NASCIMENTO, porém com CODIGO divergente de um cadastrado previamente
            $existingPatient = Patient::whereHas('user', function ($query) use ($nome, $nascimento) {
                $query->where('name', $nome)->where('birth_date', $nascimento);
            })->first();

            if ($existingPatient && $existingPatient->social_number != $codigo) {
                $isValid = false;
                $errorMessages[] = 'Paciente já cadastrado com outro código.';
            }

            // RN02-02: Internações com o mesmo código da GUIA de internação
            if (Guide::where('description', $guia)->exists()) {
                $isValid = false;
                $errorMessages[] = 'Guia de internação já cadastrada.';
            }

            // RN02-03: Internações com a data de ENTRADA inferior a data de NASCIMENTO do paciente
            if ($entrada < $nascimento) {
                $isValid = false;
                $errorMessages[] = 'Data de entrada não pode ser anterior à data de nascimento.';
            }

            // RN02-04: Internações com a data de SAÍDA inferior ou igual à data de ENTRADA
            if ($saida < $entrada) {
                $isValid = false;
                $errorMessages[] = 'Data de saída deve ser posterior à data de entrada.';
            }

            // RN02-05: Internações do mesmo paciente com conflito de datas
            if ($existingPatient) {
                $conflictingGuide = Guide::where('patient_id', $existingPatient->id)
                    ->where(function ($query) use ($entrada, $saida) {
                        $query->where(function ($q) use ($entrada, $saida) {
                            $q->where('entry', '<=', $entrada)
                                ->where('exit', '>=', $entrada);
                        })->orWhere(function ($q) use ($entrada, $saida) {
                            $q->where('entry', '<=', $saida)
                                ->where('exit', '>=', $saida);
                        });
                    })
                    ->first();

                if ($conflictingGuide) {
                    $isValid = false;
                    $errorMessages[] = 'Conflito de datas com uma internação já registrada.';
                }
            }

            $arrayValues[$key]['var_isValid'] = $isValid;
            $arrayValues[$key]['var_errorMessages'] = $errorMessages;
        }

        // Enviar dados para revisão do usuário
        return view('admin.hospitalization-up-csv', [
            'var_validEntries' => collect($arrayValues)->where('var_isValid', true)->all(),
            'var_invalidEntries' => collect($arrayValues)->where('var_isValid', false)->all()
        ]);
    }

    public function confirmImport(Request $request)
    {
        $validatedData = $request->input('data');

        foreach ($validatedData as $row) {
            if ($row['var_isValid']) {
                // Se o paciente já existir, utilizar o ID, senão criar um novo
                $patient = Patient::whereHas('user', function ($query) use ($row) {
                    $query->where('name', $row['var_nome'])
                        ->where('birth_date', Carbon::parse($row['var_nascimento']));
                })->first();

                if (!$patient) {
                    $user = User::create([
                        'name' => $row['var_nome'],
                        'email' => 'sem@email.com',
                        'password' => bcrypt('defaultpassword'),
                        'birth_date' => Carbon::parse($row['var_nascimento']),
                    ]);

                    $patient = Patient::create([
                        'user_id' => $user->id,
                        'social_number' => $row['var_codigo'],
                    ]);
                }

                Guide::create([
                    'patient_id' => $patient->id,
                    'description' => $row['var_guia'],
                    'entry' => Carbon::parse($row['var_entrada']),
                    'exit' => isset($row['var_saida']) ? Carbon::parse($row['var_saida']) : null,
                ]);
            }
        }

        return redirect()->route('hospitalization.index')->with('success', 'Dados do CSV importados com sucesso!');
    }

}
