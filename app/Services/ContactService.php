<?php

namespace App\Services;

use App\Interfaces\IContactRepository;
use App\Interfaces\IContactService;
use App\Interfaces\ILinkService;
use App\Interfaces\IPhoneService;
use Illuminate\Support\Facades\DB;
use Exception;

class ContactService implements IContactService
{
    private IContactRepository $contactRepository;
    private ILinkService $linkService;
    private IPhoneService $phoneService;

    public function __construct(
        IContactRepository $contactRepository,
        ILinkService $linkService,
        IPhoneService $phoneService
    ) {
        $this->contactRepository = $contactRepository;
        $this->linkService = $linkService;
        $this->phoneService = $phoneService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Array
     */
    public function all()
    {
        $contacts = $this->contactRepository->all();

        foreach ($contacts as $key => $contact) {
            $contacts[$key]['links'] = $contact->links;
            foreach($contact->links as $keyLink => $link){
                $contacts[$key]['links'][$keyLink]['link_type'] = $link->link_type;
            }
            $contacts[$key]['phones'] = $contact->phones;
            foreach($contact->phones as $keyPhone => $phone){
                $contacts[$key]['phones'][$keyPhone]['phone_type'] = $phone->phone_type;
            }
        }

        return $contacts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function store(Array $data)
    {
        try {
            DB::beginTransaction();

            $contact = $this->contactRepository->store($data);

            if (!empty($data['links'])) {
                foreach($data['links'] as $link){
                    $linkData = $link;
                    $linkData['contact_id'] = $contact->id;
                    $this->linkService->store($linkData);
                }
            }

            if (!empty($data['phones'])) {
                foreach($data['phones'] as $phone){
                    $phoneData = $phone;
                    $phoneData['contact_id'] = $contact->id;
                    $this->phoneService->store($phoneData);
                }
            }
            
            $response = $contact;
            $response['links'] = $contact->links;
            foreach($contact->links as $key => $link){
                $response['links'][$key]['link_type'] = $link->link_type;
            }
            $response['phones'] = $contact->phones;
            foreach($contact->phones as $key => $phone){
                $response['phones'][$key]['phone_type'] = $phone->phone_type;
            }
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = $th->getCode();
        }
        
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Array
     */
    public function show(int $id)
    {
        if (empty($contact = $this->contactRepository->show($id))) {
            throw new Exception('Contato informado não existe!');
        }

        $response = $contact;
        $response['links'] = $contact->links;
        foreach($contact->links as $key => $link){
            $response['links'][$key]['link_type'] = $link->link_type;
        }
        $response['phones'] = $contact->phones;
        foreach($contact->phones as $key => $phone){
            $response['phones'][$key]['phone_type'] = $phone->phone_type;
        }

        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return Array
     */
    public function update(Array $data, int $id)
    {
        try {
            DB::beginTransaction();
            if (empty($this->contactRepository->show($id))) {
                throw new Exception('Contato informado não existe!');
            }
            
            if (empty($contact = $this->contactRepository->update($data, $id))) {
                throw new Exception('Falha ao atualizar o contato!');
            }

            foreach($contact->links as $link){
                if(empty($data['links']) || array_search($link->id, array_column($data['links'], 'id')) === false){
                    $this->linkService->destroy($link->id);
                }
            }
            
            foreach($contact->phones as $phone){
                if(empty($data['phones']) || array_search($phone->id, array_column($data['phones'], 'id')) === false){
                    $this->phoneService->destroy($phone->id);
                }
            }
            
            if (!empty($data['links'])) {
                foreach($data['links'] as $link){
                    $linkData = $link;
                    $linkData['contact_id'] = $contact->id;
                    if(isset($link['id'])){
                        $this->linkService->update($linkData, $link['id']);
                    } else {
                        $this->linkService->store($linkData);
                    }
                }
            }

            if (!empty($data['phones'])) {
                foreach($data['phones'] as $phone){
                    $phoneData = $phone;
                    $phoneData['contact_id'] = $contact->id;

                    if(isset($phone['id'])){
                        $this->phoneService->update($phoneData, $phone['id']);
                    } else {
                        $this->phoneService->store($phoneData);
                    }
                }
            }

            $response = $contact;
            $response['links'] = $contact->links;
            foreach($contact->links as $key => $link){
                $response['links'][$key]['link_type'] = $link->link_type;
            }
            $response['phones'] = $contact->phones;
            foreach($contact->phones as $key => $phone){
                $response['phones'][$key]['phone_type'] = $phone->phone_type;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = 406;
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Array
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();

            if (empty($contact = $this->contactRepository->show($id))) {
                throw new Exception('Contato informado não existe!');
            }

            $contact_links = $contact->links;
            foreach($contact->links as $key => $link){
                $contact_links[$key]['link_type'] = $link->link_type;
            }
            $contact_phones = $contact->phones;
            foreach($contact_phones as $key => $phone){
                $contact_phones[$key]['phone_type'] = $phone->phone_type;
            }

            if (!empty($contact_links)) {
                foreach($contact_links as $link){
                    $this->linkService->destroy($link['id']);
                }
            }

            if (!empty($contact_phones)) {
                foreach($contact_phones as $phone){
                    $this->phoneService->destroy($phone['id']);
                }
            }

            $response = $this->contactRepository->destroy($id);
            $response['links'] = $contact_links;
            $response['phones'] = $contact_phones;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = 406;
        }

        return $response;
    }
}
