<?php namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\DesignerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class DesignerDashboardController
 * @package App\Http\Controllers\Designer
 */
class DesignerDashboardController extends Controller
{
    /**
     * Designer Repository
     * @var DesignerRepository
     */
    public $repository;

    /**
     * DesignerDashboardController constructor.
     */
    public function __construct()
    {
        $this->repository = new DesignerRepository();
        $this->middleware('designer');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard()
    {
        return view('designer.dashboard.dashboard');
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

        return view('designer.profile.profile')->with([
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
        }

        $this->validator($input)->validate();

        unset($input['password_confirmation']);

        $result         = $this->repository->updateMyProfile($input);
        $alertMessage   = ($result) ? 'Profile data updated successfully!' : 'Failed to update profile data!';
        $alertType      = ($result) ? 'success' : 'danger';

        garmentor_set_alert_message_cookie($alertMessage, $alertType);

        return redirect()->route('designer.profile.edit');
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
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|string|email',
            'phone'         => 'required|numeric',
            'password'      => 'string|min:6|confirmed',
        ]);
    }
}