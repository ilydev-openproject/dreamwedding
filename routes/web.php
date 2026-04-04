// Emergency Storage Link (For Hostinger/Vercel)
Route::get('/fix-storage', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    
    if (file_exists($link)) {
        if (is_link($link)) {
            unlink($link);
        } else {
            return "Folder public/storage sudah ada sebagai FOLDER asli, bukan link. Silakan hapus manual dulu di File Manager.";
        }
    }
    
    if (symlink($target, $link)) {
        return "Berhasil Bos! Storage Link sudah terpasang. Sekarang foto pasti muncul.";
    } else {
        return "Gagal membuat link. Coba hapus folder 'public/storage' di File Manager Hostinger lalu buka lagi link ini.";
    }
});
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RsvpController;

// Web root
Route::get('/', function () {
    return redirect('/admin');
});

// For Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/clients', [AdminController::class, 'clients'])->name('admin.clients');
Route::get('/admin/themes', [AdminController::class, 'themes'])->name('admin.themes');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/invitations', [AdminController::class, 'store'])->name('admin.store');
Route::put('/admin/clients/{id}/theme', [AdminController::class, 'updateTheme'])->name('admin.updateTheme');

// For Customer Dashboard using Magic Link Token
Route::get('/dashboard/{token}', [DashboardController::class, 'show'])->name('dashboard.show');
Route::post('/dashboard/{token}', [DashboardController::class, 'update'])->name('dashboard.update');

// For Public Viewer
Route::get('/invite/{slug}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/invite/{slug}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::patch('/dashboard/rsvp/{id}/reply', [RsvpController::class, 'updateReply'])->name('rsvp.reply');
Route::delete('/dashboard/rsvp/{id}', [RsvpController::class, 'destroy'])->name('rsvp.destroy');
Route::get('/demo/{template_id}', [InvitationController::class, 'demo'])->name('invitation.demo');
