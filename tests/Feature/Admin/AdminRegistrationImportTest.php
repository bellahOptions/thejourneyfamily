<?php

use App\Models\RetreatRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

$sourceFormatCsv = function (): string {
    $header = '"Timestamp","Name ","Wedding Anniversary (Date and Month)","Your WhatsApp Enabled Number","Your Spouse\'s WhatsApp Enabled Number","The program is taking place at the Redemption camp, do you have the means to commute there? (Are you mobile?)","Will you coming with children?","If yes, how old are they?","What are your expectations for this year\'s retreat? (Optional)","What is your prayer request as a couple?","Feedback from last year\'s retreat or previous years","I have made payment","If yes, kindly send proof of payment to this number on WhatsApp; 08054461053","If you any other question(s), kindly drop them here"';

    $rows = [
        '"2026/06/14 10:10:09 AM GMT+1","Samuel Emmanuel","2026-06-27","08168586777","08134804655","Yes","No","Nil","Spiritual insights","Lord help us","Great last year","No","Nil","None for now"',
        '"2026/06/18 10:10:22 PM GMT+1","Dickson Victor","2026-10-14","08038702891","08162284187","Not mobile but can commute there","Yes","A 2 year old boy","","","","No","",""',
        '"2026/06/20 10:00:00 AM GMT+1","Bad Date Couple","not-a-real-date","08000000000","08111111111","Yes","No","","","","","No","",""',
        '"2026/06/21 10:00:00 AM GMT+1","","2020-01-01","08000000001","08111111112","Yes","No","","","","","No","",""',
    ];

    return implode("\n", [$header, ...$rows]);
};

test('an admin can import registrations from the source csv format', function () use ($sourceFormatCsv) {
    $admin = User::factory()->admin()->create();

    $file = UploadedFile::fake()->createWithContent('import.csv', $sourceFormatCsv());

    $response = $this->actingAs($admin)->post(route('admin.registrations.import.store'), [
        'file' => $file,
    ]);

    $response->assertRedirect(route('admin.registrations.import'));

    $this->assertDatabaseCount('retreat_registrations', 2);

    $this->assertDatabaseHas('retreat_registrations', [
        'couple_name' => 'Samuel Emmanuel',
        'anniversary_day' => 27,
        'anniversary_month' => 6,
        'email' => null,
        'package_key' => null,
        'payment_made' => 'No',
        'transport_status' => 'Yes',
    ]);

    $this->assertDatabaseHas('retreat_registrations', [
        'couple_name' => 'Dickson Victor',
        'transport_status' => 'Other',
        'transport_notes' => 'Not mobile but can commute there',
        'bringing_children' => 'Yes',
        'children_ages' => 'A 2 year old boy',
    ]);

    $summary = session('importSummary');
    expect($summary['imported'])->toBe(2);
    expect($summary['duplicates'])->toBe(0);
    expect($summary['skipped'])->toHaveCount(2);
});

test('re-importing the same file skips duplicates', function () use ($sourceFormatCsv) {
    $admin = User::factory()->admin()->create();
    $csv = $sourceFormatCsv();

    $this->actingAs($admin)->post(route('admin.registrations.import.store'), [
        'file' => UploadedFile::fake()->createWithContent('import.csv', $csv),
    ]);

    $response = $this->actingAs($admin)->post(route('admin.registrations.import.store'), [
        'file' => UploadedFile::fake()->createWithContent('import-again.csv', $csv),
    ]);

    $response->assertRedirect(route('admin.registrations.import'));
    $this->assertDatabaseCount('retreat_registrations', 2);

    $summary = session('importSummary');
    expect($summary['imported'])->toBe(0);
    expect($summary['duplicates'])->toBe(2);
});

test('imported registrations flag missing email and package on the admin views', function () use ($sourceFormatCsv) {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post(route('admin.registrations.import.store'), [
        'file' => UploadedFile::fake()->createWithContent('import.csv', $sourceFormatCsv()),
    ]);

    $registration = RetreatRegistration::query()->firstOrFail();

    expect($registration->needsEmail())->toBeTrue();
    expect($registration->needsPackage())->toBeTrue();

    $this->actingAs($admin)
        ->get(route('admin.registrations.show', $registration))
        ->assertOk()
        ->assertSee('No email')
        ->assertSee('Needs package');
});

test('a non-admin cannot access the import page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.registrations.import'))
        ->assertForbidden();
});
