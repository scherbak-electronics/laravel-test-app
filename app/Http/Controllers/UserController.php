<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use App\Transaction;
use App\Services\TransactionService;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * The transaction repository implementation.
     *
     * @var TransactionRepository
     */
    protected $transactionRepo;

    /**
     * The transaction service implementation.
     *
     * @var TransactionService
     */
    protected $transactionSrv;

    protected $faker;


    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @param  TransactionRepository  $transactionRepo
     * @return void
     */
    public function __construct(
        UserRepository $users, 
        TransactionRepository $transactionRepo,
        TransactionService $transactionSrv,
        Faker $faker
        )
    {
        $this->users = $users;
        $this->transactionRepo = $transactionRepo;
        $this->transactionSrv = $transactionSrv;
        $this->faker = $faker;
    }

    /**
     * Show index.
     *
     * @return Response
     */
    public function index()
    {
        return '';
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function show()
    {

        $users = $this->users->getAllUsers();
        return $users;
    }

    /**
     * Get the admin user.
     *
     * @return Response
     */
    public function getAdmin()
    {
        $admin = $this->users->getAdminUser();
        return $admin;
    }

    public function login(Request $request)
    {
        $id = (int)$request->id;
        if ($id) {
            $user = $this->users->getById($id);
            if ($user->id) {
                Auth::login($user);
                if (Auth::check()) {
                    return Auth::user();
                }
                return 'unable to auth';
            }
            return 'there is no user with id ' . $id;
        }
        return 'has no id';
    }

    public function getLoggedInUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }
        return '';
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Auth::logout();
            return $user;
        }
        return '';
    }

    public function addUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->admin) {
                $newUser = factory(User::class)->create();
                $newUser->name = $newUser->name . Str::random(6);
                $newUser->save();
                return $newUser;
            }
            return 'Only admins can create users.';    
        }
        return 'not logged in';
    }

    public function createTransaction()
    {
        if (Auth::check()) {
            $amount = $this->faker->randomFloat(2, 1, 50); 
            $transaction = $this->transactionSrv->createUserTransaction(Auth::user(), $amount);
            return $transaction;
        }
        return '';
    }

    public function getTransactions()
    {
        if (Auth::check()) {
            $transaction = $this->transactionRepo->getByUserId(Auth::user()->id);
            return $transaction;
        }
        return '';
    }

    public function getAllTransactions()
    {
        $transaction = $this->transactionRepo->getAllTransactions();
        return $transaction;
    }

    public function getTotals()
    {
        $usersTotals = $this->users->getLastCreatedUsersWithSumOfDebitTransactions();
        return $usersTotals;

    }

    public function getUserTotals(Request $request)
    {
        $id = (int)$request->id;
        if ($id) {
            return $this->users->getUserWithSumOfDebitTransactions($id);
        }
        return 'has no id';
    }
}
