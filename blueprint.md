SYSTEM BLUEPRINT: PC IPNU Ciamis Internal App
Stack: Laravel 11, Filament v3, MySQL.
Scope: Backend API & Backoffice Admin Panel.
Context: Single Database for one Regency (Kabupaten Ciamis).
STEP 1: DATABASE SCHEMA (MIGRATIONS)
Create migrations with the following strict structure. Use standard Laravel conventions.
1. Master Data: Wilayah (Manual)
Since we only handle one regency, do NOT use external packages.
Table: districts (Kecamatan)
id (BigInt, Primary)
name (String)
MANDATORY DATA (Seeder): The DistrictSeeder MUST populate the table with these 27 districts of Ciamis:
Banjaranyar
Banjarsari
Baregbeg
Ciamis
Cidolog
Cihaurbeuti
Cijeungjing
Cikoneng
Cimaragas
Cipaku
Cisaga
Jatinagara
Kawali
Lakbok
Lumbung
Pamarican
Panawangan
Panjalu
Panumbangan
Purwadadi
Rajadesa
Rancah
Sadananya
Sindangkasih
Sukadana
Sukamantri
Tambaksari
Table: villages (Desa/Kelurahan)
id (BigInt, Primary)
district_id (Foreign Key -> districts)
name (String)
2. Core User Data: members
Single Table Inheritance strategy for both "Anggota" and "Kader".
Table: members
id (BigInt, Primary)
nik (String, 16, Unique)
nia (String, Unique, Nullable) -> Null if not yet official/verified.
username (String, Unique)
email (String, Unique)
password (String)
full_name (String)
birth_place (String)
birth_date (Date)
address (Text)
province (String, Default: 'Jawa Barat')
city (String, Default: 'Kabupaten Ciamis')
district_id (Foreign Key -> districts)
village_id (Foreign Key -> villages)
phone_number (String)
hobby (String, Nullable)
status (Enum: 'active', 'inactive', 'banned')
grade (Enum: 'anggota', 'kader_makesta', 'kader_lakmud', 'kader_lakut')
Logic: 'anggota' = Basic member. Others = Graduated Kader.
alumni_period_id (Foreign Key -> alumni_periods, Nullable)
Logic: If this field is filled, the member is considered an Alumni of that specific period.
timestamps
softDeletes
3. Organization Structure
Table: branch_executives (Pengurus Cabang - PC)
id (BigInt, Primary)
member_id (Foreign Key -> members)
position (String) -> e.g., "Ketua", "Sekretaris"
period_start (Year/Date)
period_end (Year/Date)
is_active (Boolean)
Table: pac_executives (Pengurus Anak Cabang - PAC)
id (BigInt, Primary)
district_id (Foreign Key -> districts) -> Defines which PAC structure this is.
member_id (Foreign Key -> members)
position (String)
period_start (Date)
period_end (Date)
is_active (Boolean)
4. Kaderisasi (Training)
Table: cadre_events
id (BigInt, Primary)
name (String) -> e.g., "Makesta Raya Banjarsari"
type (Enum: 'makesta', 'lakmud', 'lakut')
start_date (Date)
end_date (Date)
location (String)
description (Text, Nullable)
Table: cadre_event_participants (Pivot)
id (BigInt, Primary)
cadre_event_id (Foreign Key -> cadre_events)
member_id (Foreign Key -> members)
status (Enum: 'registered', 'graduated', 'failed')
certificate_number (String, Nullable)
5. CMS (Content)
Table: categories: name, slug.
Table: posts: title, slug, content (LongText), image_path, category_id, is_published (Boolean).
6. Alumni Management
Table: alumni_periods
id (BigInt, Primary)
title (String) -> e.g., "Masa Khidmat 2020-2022" or "Angkatan Khotami”
period_year (String) -> e.g., "2020-2022"
description (Text, Nullable)
STEP 2: ELOQUENT RELATIONSHIPS
Define these in the Models strictly.
District Model:
hasMany(Village::class)
hasMany(Member::class) -> "Anggota PAC"
hasMany(PacExecutive::class) -> "Pengurus PAC"
Member Model:
belongsTo(District::class)
belongsToMany(CadreEvent::class, 'cadre_event_participants')
belongsTo(AlumniPeriod::class)
CadreEvent Model:
belongsToMany(Member::class, 'cadre_event_participants')->withPivot('status', 'certificate_number')
AlumniPeriod Model:
hasMany(Member::class)
STEP 3: BUSINESS LOGIC AUTOMATION (CRITICAL)
Requirement: Auto-upgrade Member Grade upon Graduation.
Implementation: Create a Model Observer for CadreEventParticipant (or handle in Filament Action).
Logic:
WHEN a participant's pivot status is updated to 'graduated':
IF Event Type is 'makesta' -> UPDATE Member grade to 'kader_makesta'
IF Event Type is 'lakmud' -> UPDATE Member grade to 'kader_lakmud'
IF Event Type is 'lakut' -> UPDATE Member grade to 'kader_lakut'
STEP 4: FILAMENT RESOURCES (UI/UX BLUEPRINT)
1. Resource: PacResource
Model: District (Not PacExecutive, but District acts as the PAC wrapper).
Label: "Pimpinan Anak Cabang".
Navigation Icon: Heroicon building-office-2.
Table Column: Name (Kecamatan).
View/Edit Page:
Hide standard form fields (except name).
Display RelationManagers (Tabs):
PengurusRelationManager: Lists PacExecutive. Columns: Name (Member), Position, Status.
AnggotaRelationManager: Lists Member where district_id matches. Columns: NIK, Name, Grade.
Goal: Clicking a PAC name allows admin to manage Executives and Members for THAT specific district in one place.
2. Resource: MemberResource
Form:
Personal Info Section.
Address Section:
Select::make('district_id') -> Reactive.
Select::make('village_id') -> Options depend on selected district_id.
Alumni Info Section (Collapsible):
Select::make('alumni_period_id') -> To manually assign alumni status if needed.
Table Filters:
SelectFilter by Grade (Anggota vs Kader).
SelectFilter by District (Kecamatan).
Header Actions:
Import: Use maatwebsite/excel. Validate NIK uniqueness.
Export: Download list as Excel.
3. Resource: CadreEventResource
RelationManager: ParticipantsRelationManager.
Allow attaching existing Members.
Allow creating NEW Members (via modal) if they don't exist yet.
Table Action inside RelationManager: "Set Lulus". Trigger the Logic defined in Step 3.
4. Resource: PostResource (CMS)
Use RichEditor or MarkdownEditor.
Image upload with image() field.
5. Resource: AlumniPeriodResource
Label: "Data Alumni".
Navigation Icon: Heroicon academic-cap.
Table Column: Title ("Masa Khidmat 2020-2022"), Period Year.
View/Edit Page:
Display RelationManager: AlumniMembersRelationManager.
Lists Member data associated with this period.
Columns to show: Name, Address, Current Job/Hobby.
Header Actions: Export Data Alumni per periode.
STEP 5: API ENDPOINTS (FOR FRONTEND)
Create Api\PostController.
GET /api/posts -> Return paginated JSON (Title, Slug, Image, Excerpt, Category).
GET /api/posts/{slug} -> Return detail content.
EXECUTION ORDER FOR AI
Generate Migrations based on Step 1 (include new Alumni tables).
Generate Models & Relationships based on Step 2.
Generate Filament Resources based on Step 4 (Focus on the new AlumniPeriodResource relation).
Implement Observer Logic based on Step 3.
Install maatwebsite/excel and configure Export/Import actions.
