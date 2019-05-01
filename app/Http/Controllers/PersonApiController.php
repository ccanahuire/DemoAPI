<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class PersonApiController
 * @package App\Http\Controllers
 */
class PersonApiController extends Controller
{
    /**
     * [GET] Retrieves the list of all the persons registered.
     *
     * @return JsonResponse
     */
    public function retrieveAll() {
        $personList = Person::all();
        return response()->json($personList, 200);
    }

    /**
     * [GET] Retrieves the person info identified by the given id.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function retrieve($id) {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['error_message' => "Couldn't find the person with id = $id."], 404);
        }

        return response()->json($person, 200);
    }

    /**
     * [POST] Creates a person with the given data.
     *
     * @param CreatePersonRequest $request
     * @return JsonResponse
     */
    public function create(CreatePersonRequest $request) {
        $person = new Person();
        $person->full_name = $request->full_name;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->save();
        return response()->json(['success' => true, "id" => $person->id], 201);
    }

    /**
     * [PATCH] Updates the person information.
     *
     * @param int $id
     * @param UpdatePersonRequest $request
     * @return Response
     */
    public function update($id, UpdatePersonRequest $request) {
        /** @var Person $person */
        $person = Person::find($id);
        if ($person === null) {
            abort(404);
        }

        $person->full_name = $request->full_name;
        $person->email = $request->email;
        $person->phone = $request->phone;
        $person->save();

        return response(null, 204);
    }

    /**
     * [DELETE] Deletes a person record from the database.
     *
     * @param $id
     * @return Response
     */
    public function delete($id) {
        $person = Person::find($id);
        if ($person === null) {
            return response()->json(['error_message' => "Couldn't find the person with id = $id."], 404);
        }

        $person->delete();

        return response(null, 204);
    }
}
