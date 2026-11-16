<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationAndProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_the_expected_background_and_redirects_authenticated_users(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk()
            ->assertSee('bg-unpam.jpg')
            ->assertSee('name="_token"', false);

        $this->actingAs(User::factory()->create())
            ->get(route('login'))
            ->assertRedirect(route('admin.home'));
    }

    public function test_valid_credentials_authenticate_and_redirect_to_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.action'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_return_to_login_with_an_error(): void
    {
        $this->post(route('login.action'), [
            'email' => 'admin@example.com',
            'password' => 'incorrect',
        ])->assertRedirect(route('login'))
            ->assertSessionHas('error', 'Email atau password salah.');

        $this->assertGuest();
    }

    public function test_admin_pages_require_authentication(): void
    {
        $this->get(route('admin.home'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.project.index'))
            ->assertRedirect(route('login'));
    }

    public function test_dashboard_shows_the_authenticated_user_and_success_message(): void
    {
        $user = User::factory()->create(['name' => 'Demo Admin']);

        $this->actingAs($user)
            ->withSession(['success' => 'Project berhasil diperbarui.'])
            ->get(route('admin.home'))
            ->assertOk()
            ->assertSee('Demo Admin')
            ->assertSee('Project berhasil diperbarui.')
            ->assertSee('Projects')
            ->assertSee('Logout');
    }

    public function test_logout_invalidates_the_authenticated_session(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_demo_admin_account_is_seeded_with_a_hashed_password(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->assertSame('adminwok', $user->name);
        $this->assertTrue(Hash::check('adminwok', $user->password));
        $this->assertNotSame('adminwok', $user->password);
    }

    public function test_authenticated_user_can_manage_projects_and_upload_an_image(): void
    {
        $user = User::factory()->create();
        $image = UploadedFile::fake()->image('project.png');

        $this->actingAs($user)
            ->post(route('admin.project.store'), [
                'title' => 'Portfolio',
                'description' => 'A sample project',
                'teknologi' => 'Laravel',
                'status' => 'selesai',
                'image' => $image,
            ])
            ->assertRedirect(route('admin.project.index'))
            ->assertSessionHas('success', 'Project berhasil ditambahkan.');

        $project = Project::query()->where('title', 'Portfolio')->firstOrFail();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'description' => 'A sample project',
            'teknologi' => 'Laravel',
            'status' => 'selesai',
        ]);
        $this->assertFileExists(public_path('images/'.$project->image));

        $this->put(route('admin.project.update', $project), [
            'title' => 'Updated Portfolio',
            'description' => 'Updated description',
            'teknologi' => 'Laravel and Bootstrap',
            'status' => 'In Progress',
        ])->assertRedirect(route('admin.project.index'))
            ->assertSessionHas('success', 'Project berhasil diperbarui.');

        $project->refresh();
        $this->assertSame('Updated Portfolio', $project->title);
        $this->assertSame('In Progress', $project->status);

        $this->delete(route('admin.project.destroy', $project))
            ->assertRedirect(route('admin.project.index'))
            ->assertSessionHas('success', 'Project berhasil dihapus.');

        $this->assertModelMissing($project);
        $this->assertFileDoesNotExist(public_path('images/'.$project->image));
    }

    public function test_project_creation_rejects_missing_title_and_non_image_uploads(): void
    {
        $this->actingAs(User::factory()->create())
            ->from(route('admin.project.create'))
            ->post(route('admin.project.store'), [
                'title' => '',
                'status' => 'selesai',
                'image' => UploadedFile::fake()->create('document.txt', 10, 'text/plain'),
            ])
            ->assertRedirect(route('admin.project.create'))
            ->assertSessionHasErrors(['title', 'image']);

        $this->assertDatabaseCount('projects', 0);
    }
}
