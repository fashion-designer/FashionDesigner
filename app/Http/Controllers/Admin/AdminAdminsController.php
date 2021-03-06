<?php namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Repositories\Admin\AdminRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\ContactFormRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminAdminsController
 * @package App\Http\Controllers\Admin
 */
class AdminAdminsController extends Controller
{
    /**
     * @var AdminRepository
     */
    public $repository;

    /**
     * AdminDesignersController constructor.
     */
    public function __construct()
    {
        $this->repository = new AdminRepository();
        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|numeric',
            'password' => 'string|min:6|confirmed',
        ]);
    }

    /**
     * Designers List
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $list       = $this->repository->getList();
        $alert      = garmentor_get_alert_message_cookie();

        return view('admin.admins.list')->with([
            'list'  => $list,
            'alert' => ($alert) ? $alert : false
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $profile = $this->repository->getAdminProfile($id);

        return response()->json($profile);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $result         = $this->repository->updateAdminProfile($id, $request->all());
        $alertMessage   = ($result) ? 'Profile data updated successfully!' : 'Failed to update profile data!';
        $alertType      = ($result) ? 'success' : 'danger';

        garmentor_set_alert_message_cookie($alertMessage, $alertType);

        return redirect()->route('admin.admins-list.edit', $id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite(Request $request)
    {
        $genders = $this->repository->getAllGenders();

        return view('admin.admins.invite')->with(['genders' => $genders]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendInvitation(Request $request)
    {
        $accountDetails = (new Admin())->where('email', $request->get('email'))->first();

        if($accountDetails)
        {
            $alertMessage   = 'An account with this email already exist!';
            $alertType      = 'danger';
        }
        else
        {
            $invited = $this->repository->sendInvitation($request->all());

            if($invited)
            {
                $alertMessage   = 'Invited admin successfully!';
                $alertType      = 'success';
            }
            else
            {
                $alertMessage   = 'Failed to invite admin!';
                $alertType      = 'danger';
            }
        }

        garmentor_set_alert_message_cookie($alertMessage, $alertType);

        return redirect()->route('admin.admins-list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMyProfile(Request $request)
    {
        $profileData    = $this->repository->getMyProfile();
        $genders        = $this->repository->getAllGenders();
        $alert          = garmentor_get_alert_message_cookie();

        return view('admin.profile.profile')->with([
            'profile' => $profileData,
            'genders' => $genders,
            'alert'   => ($alert) ? $alert : false,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function updateMyProfile(Request $request)
    {
        $input = $request->all();

        if(array_key_exists('password', $input) && $input['password'] === null)
        {
            unset($input['password']);
            unset($input['password_confirmation']);
        }

        $this->validator($input)->validate();

        $result         = $this->repository->updateMyProfile($input);
        $alertMessage   = ($result) ? 'Profile data updated successfully!' : 'Failed to update profile data!';
        $alertType      = ($result) ? 'success' : 'danger';

        garmentor_set_alert_message_cookie($alertMessage, $alertType);

        return redirect()->route('admin.profile.edit');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactRequests()
    {
        $allRequests = (new ContactFormRepository())->getAllRequests();

        return view('admin.contact-requests.list')->with(['allRequests' => $allRequests]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewContactRequests(Request $request, $id)
    {
        $details = (new ContactFormRepository())->getRequestDetails($id);

        return view('admin.contact-requests.view')->with(['details' => $details[0]]);
    }
}