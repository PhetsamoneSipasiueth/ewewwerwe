<?php



use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
      return view('welcome');

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users=DB::table('users')->get();
    return view('dashboard',compact('users'));
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function(){
     Route::get('/department/all', [DepartmentController::class,'index'])->name('department');
    Route::post( '/department/add',[DepartmentController::class,'store'])->name( 'addDepartment' );
    Route::get('/department/edit/{id}' ,[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}' ,[DepartmentController::class,'update']);

    Route::get('/department/softdelete/{id}' ,[DepartmentController::class,'softdelete']);
    Route::get('/department/restore/{id}' ,[DepartmentController::class,'restore']);
    Route::get('/department/delete/{id}' ,[DepartmentController::class,'delete']);

    Route::get('/service/all', [ServiceController::class,'index'])->name('services');
    Route::post('/service/add/}' ,[ServiceController::class,'store'])->name('addService');

    Route::get('/service/edit/{id}',[ServiceController::class,'edit']);
    Route::post('/service/update/{id}',[ServiceController::class,'update']);
    Route::get('/service/delete/{id}',[ServiceController::class,'delete']);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});
require __DIR__.'/auth.php';


