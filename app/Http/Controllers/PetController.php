<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PetStoreApiService;
use Illuminate\Http\Client\RequestException;

class PetController extends Controller
{
    protected PetstoreApiService $apiService;

    public function __construct(PetstoreApiService $apiService) {

        $this->apiService = $apiService;
    }

    public function create() {
        return view('pets.create');
    }

    public function show($id)
    {
        try {
            $pet = $this->apiService->getPet($id);
            return view('pets.show', compact('pet'));
        } catch (RequestException $e) {
            return redirect()->route('pets.create')->withErrors('Pet nie został znaleziony.');
        }
    }


    public function store(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'category' => 'required|string',
            'photoUrls' => 'required|string',
            'tags' => 'required|string',
            'status' => 'required|string',
        ]);
    
        $petData = $request->all();
    
        $petData['category'] = json_decode($petData['category'], true);
        $petData['photoUrls'] = json_decode($petData['photoUrls'], true);
        $petData['tags'] = json_decode($petData['tags'], true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors('Niepoprawny format JSON w fieldach: category, photoUrls, or tags')->withInput();
        }
    
        try {
            $this->apiService->addPet($petData);
            return redirect()->route('pets.create')->with('success', 'Pet został dodany.');
        } catch (RequestException $e) {
            return back()->withErrors('Nie udało się dodać pet\'a: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $petData = $request->all();
            $petData['id'] = $id; 
            $this->apiService->updatePet($petData);
            return redirect()->route('pets.show', ['id' => $id])->with('success', 'Pet został zaktualizowany.');
        } catch (RequestException $e) {
            return back()->withErrors('Nie udało sie zaktualizować pet\'a: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $pet = $this->apiService->getPet($id);
            return view('pets.edit', compact('pet'));
        } catch (RequestException $e) {
            return redirect()->route('pets.create')
                ->withErrors('Pet not found or an error occurred: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $this->apiService->deletePet($id);
            return redirect()->route('pets.create')->with('success', 'Pet został usunięty.');
        } catch (RequestException $e) {
            return back()->withErrors('Nie udało sie usunąć pet\'a: ' . $e->getMessage());
        }
    }


}