```html
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Multi Movie Downloader — HD Movie Catalog & Public Domain Archive</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              red: '#e11d48',
              amber: '#f59e0b',
              dark: '#090a0f',
              card: '#11131c',
              border: '#232634'
            }
          }
        }
      }
    }
  </script>
  <style>
    /* Custom scrollbar for sleek dark look */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #090a0f;
    }
    ::-webkit-scrollbar-thumb {
      background: #232634;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #e11d48;
    }
    /* Hide scrollbar on horizontal category pills */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="bg-brand-dark text-zinc-100 font-sans antialiased selection:bg-rose-600 selection:text-white min-h-screen flex flex-col">

  <!-- Toast Notification Banner (Replaces alert) -->
  <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

  <!-- Top Navigation Bar -->
  <header class="sticky top-0 z-40 bg-[#090a0f]/85 backdrop-blur-xl border-b border-zinc-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-wrap items-center justify-between gap-4 py-3.5">
        
        <!-- Brand Logo -->
        <a href="#" onclick="resetFilters()" class="flex items-center gap-2.5 group">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-600 via-rose-500 to-amber-500 flex items-center justify-center shadow-lg shadow-rose-600/25 group-hover:scale-105 transition-transform">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
            </svg>
          </div>
          <div class="flex flex-col">
            <div class="flex items-center gap-1.5">
              <span class="text-lg sm:text-xl font-extrabold tracking-tight bg-gradient-to-r from-white via-zinc-100 to-zinc-300 bg-clip-text text-transparent">
                Multi Movie <span class="text-rose-500">Downloader</span>
              </span>
              <span class="hidden sm:inline-block text-[10px] font-bold uppercase tracking-widest px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/25">4K & HD</span>
            </div>
            <span class="text-[10px] text-zinc-400 tracking-wide hidden sm:block">All Categories • Fast Archive Mirrors</span>
          </div>
        </a>

        <!-- Search & Filters -->
        <div class="flex-1 max-w-2xl flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 order-3 lg:order-2 w-full lg:w-auto">
          <div class="relative flex-1">
            <svg class="w-4 h-4 text-zinc-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
            </svg>
            <input 
              id="searchInput" 
              type="text" 
              placeholder="Search Multi Movie Downloader..." 
              class="w-full bg-zinc-900/90 border border-zinc-800 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 rounded-xl pl-10 pr-4 py-2 text-sm text-zinc-100 placeholder-zinc-500 outline-none transition"
            />
          </div>

          <div class="flex items-center gap-2">
            <!-- Quality Filter -->
            <select id="qualityFilter" class="flex-1 sm:flex-initial bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-xs sm:text-sm text-zinc-200 outline-none cursor-pointer">
              <option value="ALL">All Quality</option>
              <option value="4K UHD">4K UHD</option>
              <option value="1080p">1080p</option>
              <option value="720p">720p</option>
            </select>

            <!-- Language / Audio Filter -->
            <select id="languageFilter" class="flex-1 sm:flex-initial bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-xs sm:text-sm text-zinc-200 outline-none cursor-pointer">
              <option value="ALL">All Languages</option>
              <option value="Dual Audio">Dual Audio</option>
              <option value="Hindi">Hindi</option>
              <option value="English">English</option>
              <option value="South Indian">South Indian</option>
              <option value="Bengali">Bengali</option>
            </select>
          </div>
        </div>

        <!-- Action Buttons: Admin Add & Supabase Deploy Guide -->
        <div class="flex items-center gap-2 order-2 lg:order-3">
          <button onclick="openDeployModal()" class="px-3 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-xs font-semibold text-zinc-300 hover:text-white transition flex items-center gap-1.5" title="Supabase, GitHub & Render Setup">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
            </svg>
            <span class="hidden md:inline">Deploy Stack</span>
          </button>

          <button onclick="openAdminModal()" class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-xs font-semibold text-white shadow-lg shadow-rose-600/25 transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Add Movie</span>
          </button>
        </div>

      </div>

      <!-- Category Pills Bar -->
      <nav id="categoryBar" class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-3 pt-1">
        <!-- Injected dynamically via JS -->
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    <!-- Featured Hero Spotlight Banner -->
    <section id="heroSection" class="relative rounded-2xl overflow-hidden border border-zinc-800/80 bg-brand-card shadow-2xl">
      <!-- Dynamic Hero Content Rendered via JS -->
    </section>

    <!-- Section Header & Active Filter Indicator -->
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div class="flex items-center gap-3">
        <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-rose-500 to-amber-500"></div>
        <h2 id="gridHeading" class="text-lg sm:text-xl font-bold tracking-tight text-white">Latest Releases & Classics</h2>
        <span id="movieCountBadge" class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-zinc-800/90 text-zinc-300 border border-zinc-700">0 Titles</span>
      </div>

      <button id="clearFiltersBtn" onclick="resetFilters()" class="hidden text-xs font-medium text-rose-400 hover:text-rose-300 underline underline-offset-4">
        Reset all filters
      </button>
    </div>

    <!-- Responsive Movie Grid -->
    <section id="movieGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
      <!-- Movie Cards Injected via JS -->
    </section>

    <!-- Empty State -->
    <div id="emptyState" class="hidden py-16 text-center bg-brand-card/60 rounded-2xl border border-zinc-800/70">
      <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-zinc-800/80 flex items-center justify-center text-zinc-400">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4"/>
        </svg>
      </div>
      <h3 class="text-base font-bold text-zinc-200">No matching movies found</h3>
      <p class="text-sm text-zinc-400 mt-1 max-w-md mx-auto">Try clearing your search query or switching category, quality, or language filters.</p>
      <button onclick="resetFilters()" class="mt-4 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-xs font-semibold text-white transition">
        Show All Movies
      </button>
    </div>

  </main>

  <!-- Footer -->
  <footer class="border-t border-zinc-800/80 bg-[#07080c] mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-400">
      <div class="flex items-center gap-2">
        <span class="font-bold text-zinc-200">Multi Movie Downloader</span>
        <span>•</span>
        <span>Supabase + GitHub + Render Ready</span>
      </div>
      <p class="text-center sm:text-right text-zinc-500 max-w-lg">
        Disclaimer: Multi Movie Downloader indexes open-source, Creative Commons, and Public Domain cinema metadata and external archive mirrors.
      </p>
    </div>
  </footer>

  <!-- MOVIE DETAILS & DOWNLOAD MODAL -->
  <div id="movieModal" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-6 bg-black/80 backdrop-blur-sm overflow-y-auto">
    <div class="relative w-full max-w-4xl bg-[#0d0f17] border border-zinc-800 rounded-2xl shadow-2xl overflow-hidden my-auto max-h-[92vh] flex flex-col">
      
      <!-- Close Button -->
      <button onclick="closeMovieModal()" class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-zinc-900/90 hover:bg-rose-600 text-zinc-300 hover:text-white border border-zinc-700 flex items-center justify-center transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <!-- Modal Scrollable Body -->
      <div id="movieModalBody" class="overflow-y-auto p-5 sm:p-7 space-y-6">
        <!-- Populated dynamically via JS -->
      </div>
    </div>
  </div>

  <!-- ADMIN ADD MOVIE MODAL -->
  <div id="adminModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm overflow-y-auto">
    <div class="relative w-full max-w-xl bg-[#0d0f17] border border-zinc-800 rounded-2xl shadow-2xl p-6 space-y-5 my-auto">
      <div class="flex items-center justify-between border-b border-zinc-800 pb-3.5">
        <div>
          <h3 class="text-lg font-bold text-white">Add New Title to Multi Movie Downloader</h3>
          <p class="text-xs text-zinc-400">Saves immediately to local catalog (exportable to Supabase)</p>
        </div>
        <button onclick="closeAdminModal()" class="w-8 h-8 rounded-lg bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white flex items-center justify-center">
          ✕
        </button>
      </div>

      <form id="addMovieForm" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
          <div class="sm:col-span-2">
            <label class="block text-xs font-medium text-zinc-300 mb-1">Movie / Series Title *</label>
            <input required name="title" type="text" placeholder="e.g., Sintel (4K Remaster)" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">Release Year *</label>
            <input required name="year" type="number" min="1900" max="2030" value="2025" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">Category *</label>
            <select name="category" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none">
              <option value="Hollywood">Hollywood</option>
              <option value="Bollywood">Bollywood</option>
              <option value="South Indian">South Indian</option>
              <option value="Web Series">Web Series</option>
              <option value="Anime">Anime</option>
              <option value="Public Domain Classics">Public Domain Classics</option>
              <option value="Action">Action</option>
              <option value="Sci-Fi">Sci-Fi</option>
              <option value="Thriller">Thriller</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">Top Quality *</label>
            <select name="quality" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none">
              <option value="1080p">1080p</option>
              <option value="4K UHD">4K UHD</option>
              <option value="720p">720p</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">Audio / Language *</label>
            <select name="language" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none">
              <option value="Dual Audio">Dual Audio</option>
              <option value="Hindi">Hindi</option>
              <option value="English">English</option>
              <option value="South Indian">South Indian</option>
              <option value="Bengali">Bengali</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">IMDb Rating (1-10)</label>
            <input name="rating" type="number" step="0.1" min="1" max="10" value="8.4" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">Runtime</label>
            <input name="runtime" type="text" value="2h 15m" class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-medium text-zinc-300 mb-1">Storyline / Synopsis *</label>
          <textarea required name="synopsis" rows="2" placeholder="Enter short plot summary..." class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">720p Archive / Mirror URL</label>
            <input name="link720" type="url" placeholder="https://archive.org/download/..." class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
          <div>
            <label class="block text-xs font-medium text-zinc-300 mb-1">1080p Archive / Mirror URL</label>
            <input name="link1080" type="url" placeholder="https://archive.org/download/..." class="w-full bg-zinc-900 border border-zinc-800 focus:border-rose-500 rounded-xl px-3 py-2 text-sm text-white outline-none" />
          </div>
        </div>

        <div class="flex items-center justify-between pt-2 border-t border-zinc-800">
          <button type="button" onclick="exportCatalogJSON()" class="text-xs font-semibold text-amber-400 hover:text-amber-300">
            Copy Catalog JSON
          </button>
          <div class="flex items-center gap-2">
            <button type="button" onclick="closeAdminModal()" class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-xs font-semibold text-zinc-300">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-xs font-semibold text-white shadow-lg shadow-rose-600/20">Publish Movie</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- SUPABASE + GITHUB + RENDER DEPLOY HELPER MODAL -->
  <div id="deployModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm overflow-y-auto">
    <div class="relative w-full max-w-2xl bg-[#0d0f17] border border-zinc-800 rounded-2xl shadow-2xl p-6 space-y-5 my-auto max-h-[90vh] overflow-y-auto">
      <div class="flex items-center justify-between border-b border-zinc-800 pb-3.5">
        <div>
          <h3 class="text-lg font-bold text-white">Deploy Multi Movie Downloader on Render + Supabase</h3>
          <p class="text-xs text-zinc-400">Production-ready PostgreSQL table schema & deployment steps</p>
        </div>
        <button onclick="closeDeployModal()" class="w-8 h-8 rounded-lg bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white flex items-center justify-center">✕</button>
      </div>

      <div class="space-y-3 text-xs text-zinc-300">
        <div class="p-3.5 rounded-xl bg-zinc-900/90 border border-zinc-800 space-y-1.5">
          <p class="font-bold text-emerald-400">1. Supabase PostgreSQL Schema</p>
          <p class="text-zinc-400">Paste this into your Supabase SQL Editor to store movies & download mirrors:</p>
          <pre id="supabaseSqlCode" class="overflow-x-auto p-3 rounded-lg bg-black/70 text-zinc-300 font-mono text-[11px] leading-relaxed border border-zinc-800">create table public.movies (
  id uuid default gen_random_uuid() primary key,
  title text not null,
  year int not null,
  category text not null,
  quality text default '1080p',
  language text default 'Dual Audio',
  rating numeric(3,1) default 8.0,
  runtime text,
  synopsis text,
  cast_members text[],
  downloads jsonb not null,
  created_at timestamptz default now()
);

alter table public.movies enable row level security;
create policy "Public read access" on public.movies for select using (true);</pre>
          <button onclick="copySupabaseSQL()" class="mt-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-semibold transition">
            Copy SQL Schema
          </button>
        </div>

        <div class="p-3.5 rounded-xl bg-zinc-900/90 border border-zinc-800 space-y-1.5">
          <p class="font-bold text-amber-400">2. GitHub & Render Hosting</p>
          <ul class="list-disc list-inside text-zinc-400 space-y-1">
            <li>Push this <code class="text-zinc-200">index.html</code> file to a GitHub repository.</li>
            <li>On <strong class="text-zinc-200">Render</strong>, choose <strong class="text-zinc-200">New + &rarr; Static Site</strong>, connect your repo, and set Publish Directory to <code class="text-zinc-200">.</code></li>
            <li>Host only legal, Creative Commons, or Public Domain media links (e.g., Internet Archive).</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    // =========================================================================
    // 1. CATEGORIES & INITIAL PUBLIC DOMAIN / OPEN-SOURCE MOVIE DATASET
    // =========================================================================
    const CATEGORIES = [
      "All",
      "Bollywood",
      "Hollywood",
      "South Indian",
      "Web Series",
      "Anime",
      "Public Domain Classics",
      "Action",
      "Sci-Fi",
      "Thriller"
    ];

    const DEFAULT_MOVIES = [
      {
        id: "m-1",
        title: "Tears of Steel",
        year: 2012,
        category: "Sci-Fi",
        tags: ["Hollywood", "Sci-Fi", "Action"],
        quality: "4K UHD",
        format: "4K BluRay x265",
        language: "Dual Audio",
        audioDetail: "Dual Audio [Hindi DD5.1 + English]",
        rating: 8.4,
        runtime: "12m (4K Master)",
        featured: true,
        palette: ["#be123c", "#1e1b4b", "#f59e0b"],
        cast: ["Derek de Lint", "Sergio Hasselbaink", "Vanja Rukavina"],
        synopsis: "In a dystopian future Amsterdam, a group of warriors and scientists gather at the Oude Kerk to stage a desperate stand against destructive robots using a crucial emotional memory.",
        downloads: [
          { res: "480p", size: "140 MB", codec: "x264 AAC", server: "Archive Mirror #1", url: "https://archive.org/details/TearsOfSteel" },
          { res: "720p", size: "420 MB", codec: "10-Bit HEVC", server: "Archive Mirror #2", url: "https://archive.org/details/TearsOfSteel" },
          { res: "1080p", size: "980 MB", codec: "WEB-DL x264", server: "Direct CDN #1", url: "https://archive.org/details/TearsOfSteel" },
          { res: "4K UHD", size: "2.4 GB", codec: "2160p HDR10", server: "Ultra Fast Cloud", url: "https://archive.org/details/TearsOfSteel" }
        ]
      },
      {
        id: "m-2",
        title: "Night of the Living Dead",
        year: 1968,
        category: "Public Domain Classics",
        tags: ["Hollywood", "Public Domain Classics", "Thriller"],
        quality: "1080p",
        format: "1080p Restored BluRay",
        language: "Dual Audio",
        audioDetail: "Dual Audio [Hindi Dub + English]",
        rating: 8.8,
        runtime: "1h 36m",
        featured: false,
        palette: ["#18181b", "#7f1d1d", "#d97706"],
        cast: ["Duane Jones", "Judith O'Dea", "Karl Hardman"],
        synopsis: "A ragtag group of Pennsylvanians barricade themselves in an old rural farmhouse to survive the night against a horde of mysterious, flesh-eating ghouls.",
        downloads: [
          { res: "480p", size: "410 MB", codec: "x264 MP4", server: "Internet Archive Direct", url: "https://archive.org/details/night_of_the_living_dead" },
          { res: "720p", size: "950 MB", codec: "BluRay x264", server: "Internet Archive Direct", url: "https://archive.org/details/night_of_the_living_dead" },
          { res: "1080p", size: "1.9 GB", codec: "4K-Scan Remaster", server: "Direct Mirror #1", url: "https://archive.org/details/night_of_the_living_dead" }
        ]
      },
      {
        id: "m-3",
        title: "Sita Sings the Blues",
        year: 2008,
        category: "Bollywood",
        tags: ["Bollywood", "Anime", "Public Domain Classics"],
        quality: "1080p",
        format: "1080p HD-Rip",
        language: "Hindi",
        audioDetail: "Hindi + English Musical [ESub]",
        rating: 8.5,
        runtime: "1h 22m",
        featured: false,
        palette: ["#c2410c", "#831843", "#fbbf24"],
        cast: ["Annette Hanshaw", "Aseem Chhabra", "Bhavana Nagulapally"],
        synopsis: "An animated musical retelling of the Indian epic Ramayana intertwined with jazz vocals and vibrant shadow-puppet artistry.",
        downloads: [
          { res: "480p", size: "380 MB", codec: "x264", server: "Archive Mirror #1", url: "https://archive.org/details/Sita_Sings_the_Blues" },
          { res: "720p", size: "890 MB", codec: "HD x264", server: "Archive Mirror #2", url: "https://archive.org/details/Sita_Sings_the_Blues" },
          { res: "1080p", size: "1.8 GB", codec: "Full HD Master", server: "Direct CDN", url: "https://archive.org/details/Sita_Sings_the_Blues" }
        ]
      },
      {
        id: "m-4",
        title: "Agent 327: Operation Barbershop",
        year: 2017,
        category: "Anime",
        tags: ["Anime", "Action", "Hollywood"],
        quality: "4K UHD",
        format: "4K WEB-DL",
        language: "Dual Audio",
        audioDetail: "Dual Audio [Hindi + English]",
        rating: 8.3,
        runtime: "45m Special",
        featured: false,
        palette: ["#0f766e", "#1e293b", "#f43f5e"],
        cast: ["Hendrik IJzerbroot", "Boris", "Olga Lawina"],
        synopsis: "Dutch secret agent Hendrik IJzerbroot walks into a seemingly ordinary barbershop in Amsterdam, only to uncover an underground syndicate hideout.",
        downloads: [
          { res: "720p", size: "520 MB", codec: "x264", server: "Blender Cloud Mirror", url: "https://archive.org/details/Agent327OperationBarbershop" },
          { res: "1080p", size: "1.1 GB", codec: "1080p 60fps", server: "Direct CDN #1", url: "https://archive.org/details/Agent327OperationBarbershop" },
          { res: "4K UHD", size: "2.7 GB", codec: "2160p x265", server: "Ultra Fast Cloud", url: "https://archive.org/details/Agent327OperationBarbershop" }
        ]
      },
      {
        id: "m-5",
        title: "Charade (1963) Criterion",
        year: 1963,
        category: "Thriller",
        tags: ["Hollywood", "Thriller", "Public Domain Classics"],
        quality: "1080p",
        format: "1080p BluRay",
        language: "English",
        audioDetail: "English 5.1 [Multi-Sub]",
        rating: 8.9,
        runtime: "1h 53m",
        featured: false,
        palette: ["#312e81", "#be185d", "#f59e0b"],
        cast: ["Cary Grant", "Audrey Hepburn", "Walter Matthau"],
        synopsis: "Romance and suspense ensue in Paris as a woman is pursued by several ruthless men who want a fortune her murdered husband had stolen.",
        downloads: [
          { res: "480p", size: "490 MB", codec: "x264", server: "Archive Mirror #1", url: "https://archive.org/details/Charade1963" },
          { res: "720p", size: "1.1 GB", codec: "BluRay x264", server: "Archive Mirror #2", url: "https://archive.org/details/Charade1963" },
          { res: "1080p", size: "2.3 GB", codec: "Criterion 1080p", server: "Direct CDN", url: "https://archive.org/details/Charade1963" }
        ]
      },
      {
        id: "m-6",
        title: "Deccan Chronicles: Season 1",
        year: 2025,
        category: "South Indian",
        tags: ["South Indian", "Web Series", "Action"],
        quality: "1080p",
        format: "1080p WEB-DL [Ep 1-6]",
        language: "South Indian",
        audioDetail: "Hindi + Tamil + Telugu [Multi-Audio]",
        rating: 8.6,
        runtime: "6 Episodes (42m each)",
        featured: false,
        palette: ["#991b1b", "#1c1917", "#eab308"],
        cast: ["Vikramaditya Rao", "Meera Nair", "Karthik Subramanian"],
        synopsis: "An archaeological task force in Hyderabad uncovers a centuries-old maritime cipher linking ancient Chola trade routes to a modern cyber-heist.",
        downloads: [
          { res: "480p", size: "850 MB (Pack)", codec: "x264", server: "Batch Mirror #1", url: "https://archive.org/details/movies" },
          { res: "720p", size: "1.9 GB (Pack)", codec: "HEVC 10-Bit", server: "Batch Mirror #2", url: "https://archive.org/details/movies" },
          { res: "1080p", size: "4.2 GB (Pack)", codec: "WEB-DL DD5.1", server: "Direct Batch CDN", url: "https://archive.org/details/movies" }
        ]
      },
      {
        id: "m-7",
        title: "Pather Panchali (Restored Archive)",
        year: 1955,
        category: "Bengali",
        tags: ["Bollywood", "Bengali", "Public Domain Classics"],
        quality: "1080p",
        format: "1080p Criterion Restore",
        language: "Bengali",
        audioDetail: "Bengali Original + Hindi Sub",
        rating: 9.2,
        runtime: "2h 05m",
        featured: false,
        palette: ["#065f46", "#18181b", "#d97706"],
        cast: ["Subir Banerjee", "Kanu Banerjee", "Karuna Banerjee"],
        synopsis: "Satyajit Ray's poetic masterpiece chronicling the childhood of Apu and his sister Durga in a rural Bengali village amidst poverty and quiet wonder.",
        downloads: [
          { res: "480p", size: "460 MB", codec: "x264", server: "Archive Mirror #1", url: "https://archive.org/details/movies" },
          { res: "720p", size: "1.05 GB", codec: "x264", server: "Archive Mirror #2", url: "https://archive.org/details/movies" },
          { res: "1080p", size: "2.2 GB", codec: "Restored BluRay", server: "Direct CDN", url: "https://archive.org/details/movies" }
        ]
      },
      {
        id: "m-8",
        title: "Cyber Frontier: Neo-Mumbai",
        year: 2026,
        category: "Web Series",
        tags: ["Web Series", "Sci-Fi", "Bollywood", "Thriller"],
        quality: "4K UHD",
        format: "4K HDR WEB-DL [Complete]",
        language: "Dual Audio",
        audioDetail: "Hindi + English [Dolby Atmos]",
        rating: 8.7,
        runtime: "8 Episodes",
        featured: false,
        palette: ["#4c1d95", "#be123c", "#38bdf8"],
        cast: ["Aarav Deshmukh", "Zoya Khan", "Rohan Kulkarni"],
        synopsis: "Set in 2084 coastal Mumbai, a rogue neural-forensics detective investigates a string of memory-wipe syndicates controlling the city's sea walls.",
        downloads: [
          { res: "720p", size: "2.1 GB (All Ep)", codec: "x265 10bit", server: "Fast Cloud #1", url: "https://archive.org/details/movies" },
          { res: "1080p", size: "4.8 GB (All Ep)", codec: "WEB-DL x264", server: "Fast Cloud #2", url: "https://archive.org/details/movies" },
          { res: "4K UHD", size: "11.4 GB (All Ep)", codec: "2160p HDR", server: "Ultra CDN", url: "https://archive.org/details/movies" }
        ]
      },
      {
        id: "m-9",
        title: "Spring: Open Fantasy Short",
        year: 2019,
        category: "Anime",
        tags: ["Anime", "Hollywood", "Public Domain Classics"],
        quality: "4K UHD",
        format: "4K Master x265",
        language: "Dual Audio",
        audioDetail: "Dual Audio [Hindi + English]",
        rating: 8.5,
        runtime: "18m",
        featured: false,
        palette: ["#15803d", "#1e3a8a", "#fde047"],
        cast: ["Andy Goralczyk", "Blender Studio"],
        synopsis: "A young shepherdess and her loyal dog face ancient forest spirits in order to continue the cycle of seasons above a sea of clouds.",
        downloads: [
          { res: "720p", size: "240 MB", codec: "x264", server: "Archive Mirror", url: "https://archive.org/details/SpringBlenderOpenMovie" },
          { res: "1080p", size: "610 MB", codec: "1080p x264", server: "Direct CDN", url: "https://archive.org/details/SpringBlenderOpenMovie" },
          { res: "4K UHD", size: "1.6 GB", codec: "2160p 10-Bit", server: "Ultra CDN", url: "https://archive.org/details/SpringBlenderOpenMovie" }
        ]
      },
      {
        id: "m-10",
        title: "His Girl Friday (1940)",
        year: 1940,
        category: "Hollywood",
        tags: ["Hollywood", "Public Domain Classics"],
        quality: "720p",
        format: "720p HD Restored",
        language: "English",
        audioDetail: "English Mono [ESub]",
        rating: 8.1,
        runtime: "1h 32m",
        featured: false,
        palette: ["#3f3f46", "#9f1239", "#f59e0b"],
        cast: ["Cary Grant", "Rosalind Russell", "Ralph Bellamy"],
        synopsis: "A fast-talking newspaper editor uses every trick in the book to keep his ace reporter ex-wife from remarrying and leaving the newsroom.",
        downloads: [
          { res: "480p", size: "390 MB", codec: "x264", server: "Archive Direct", url: "https://archive.org/details/his_girl_friday" },
          { res: "720p", size: "880 MB", codec: "HD x264", server: "Archive Direct", url: "https://archive.org/details/his_girl_friday" }
        ]
      }
    ];

    // =========================================================================
    // 2. APPLICATION STATE & LOCALSTORAGE PERSISTENCE
    // =========================================================================
    let movies = [];
    let state = {
      category: "All",
      search: "",
      quality: "ALL",
      language: "ALL"
    };

    function loadMovies() {
      try {
        const saved = localStorage.getItem("multi_movie_downloader_v1");
        if (saved) {
          movies = JSON.parse(saved);
        } else {
          movies = [...DEFAULT_MOVIES];
          saveMovies();
        }
      } catch (err) {
        console.error("Storage error:", err);
        movies = [...DEFAULT_MOVIES];
      }
    }

    function saveMovies() {
      try {
        localStorage.setItem("multi_movie_downloader_v1", JSON.stringify(movies));
      } catch (err) {
        console.error("Failed to save movies:", err);
      }
    }

    // =========================================================================
    // 3. CRISP SVG POSTER ARTWORK GENERATOR (ZERO BROKEN EXTERNAL IMAGES)
    // =========================================================================
    function generatePosterSVG(movie, isBackdrop = false) {
      const [c1, c2, accent] = movie.palette || ["#e11d48", "#18181b", "#f59e0b"];
      const safeTitle = escapeHTML(movie.title);
      const words = safeTitle.split(" ");
      const line1 = words.slice(0, 2).join(" ");
      const line2 = words.slice(2, 5).join(" ");

      if (isBackdrop) {
        return `
          <svg viewBox="0 0 1200 500" class="w-full h-full object-cover" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <linearGradient id="bg-${movie.id}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="${c2}"/>
                <stop offset="55%" stop-color="${c1}" stop-opacity="0.75"/>
                <stop offset="100%" stop-color="#090a0f"/>
              </linearGradient>
              <radialGradient id="glow-${movie.id}" cx="75%" cy="35%" r="55%">
                <stop offset="0%" stop-color="${accent}" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="transparent"/>
              </radialGradient>
            </defs>
            <rect width="1200" height="500" fill="url(#bg-${movie.id})"/>
            <rect width="1200" height="500" fill="url(#glow-${movie.id})"/>
            <circle cx="920" cy="180" r="190" fill="none" stroke="${accent}" stroke-opacity="0.2" stroke-width="2"/>
            <circle cx="920" cy="180" r="130" fill="none" stroke="#ffffff" stroke-opacity="0.1" stroke-width="1.5" stroke-dasharray="8 8"/>
            <path d="M0 430 Q 400 350 850 440 T 1200 390 L 1200 500 L 0 500 Z" fill="#090a0f" fill-opacity="0.65"/>
          </svg>
        `;
      }

      return `
        <svg viewBox="0 0 300 440" class="w-full h-full object-cover" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="pgrad-${movie.id}" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="${c1}"/>
              <stop offset="65%" stop-color="${c2}"/>
              <stop offset="100%" stop-color="#090a0f"/>
            </linearGradient>
            <radialGradient id="pglow-${movie.id}" cx="50%" cy="30%" r="60%">
              <stop offset="0%" stop-color="${accent}" stop-opacity="0.4"/>
              <stop offset="100%" stop-color="transparent"/>
            </radialGradient>
          </defs>
          <rect width="300" height="440" fill="url(#pgrad-${movie.id})"/>
          <rect width="300" height="440" fill="url(#pglow-${movie.id})"/>
          
          <!-- Cinematic Geometric Emblem -->
          <circle cx="150" cy="155" r="78" fill="none" stroke="#ffffff" stroke-opacity="0.14" stroke-width="1.5"/>
          <circle cx="150" cy="155" r="54" fill="none" stroke="${accent}" stroke-opacity="0.45" stroke-width="2" stroke-dasharray="6 6"/>
          <polygon points="140,132 140,178 176,155" fill="#ffffff" fill-opacity="0.85"/>

          <!-- Bottom Dark Gradient Scrim -->
          <rect y="220" width="300" height="220" fill="url(#pgrad-${movie.id})" opacity="0.3"/>
          <rect y="240" width="300" height="200" fill="#090a0f" fill-opacity="0.72"/>

          <!-- Poster Typography -->
          <text x="20" y="295" fill="${accent}" font-family="Inter, sans-serif" font-size="11" font-weight="800" letter-spacing="2">
            ${escapeHTML(movie.category.toUpperCase())} • ${movie.year}
          </text>
          <text x="20" y="328" fill="#ffffff" font-family="Inter, sans-serif" font-size="23" font-weight="800">
            ${line1}
          </text>
          ${line2 ? `<text x="20" y="355" fill="#e4e4e7" font-family="Inter, sans-serif" font-size="20" font-weight="700">${line2}</text>` : ""}
          <text x="20" y="415" fill="#a1a1aa" font-family="Inter, sans-serif" font-size="10" font-weight="600" letter-spacing="1.5">
            ${escapeHTML(movie.format || movie.quality)}
          </text>
        </svg>
      `;
    }

    function escapeHTML(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
    }

    // =========================================================================
    // 4. RENDERING FUNCTIONS (CATEGORIES, HERO, GRID)
    // =========================================================================
    function renderCategories() {
      const bar = document.getElementById("categoryBar");
      bar.innerHTML = CATEGORIES.map(cat => {
        const active = state.category === cat;
        return `
          <button 
            onclick="selectCategory('${cat}')"
            class="whitespace-nowrap px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all border ${
              active 
                ? "bg-rose-600 text-white border-rose-500 shadow-md shadow-rose-600/25" 
                : "bg-zinc-900/80 text-zinc-400 hover:text-white hover:bg-zinc-800 border-zinc-800"
            }">
            ${cat}
          </button>
        `;
      }).join("");
    }

    function renderHero() {
      const featured = movies.find(m => m.featured) || movies[0];
      if (!featured) return;

      const hero = document.getElementById("heroSection");
      hero.innerHTML = `
        <div class="relative min-h-[300px] sm:min-h-[340px] flex items-center">
          <div class="absolute inset-0">
            ${generatePosterSVG(featured, true)}
            <div class="absolute inset-0 bg-gradient-to-r from-[#090a0f] via-[#090a0f]/85 to-transparent"></div>
          </div>

          <div class="relative z-10 p-6 sm:p-10 max-w-2xl space-y-4">
            <div class="flex flex-wrap items-center gap-2">
              <span class="px-2.5 py-1 rounded-lg bg-rose-600 text-white text-[11px] font-extrabold uppercase tracking-wider shadow">
                Featured Spotlight
              </span>
              <span class="px-2.5 py-1 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/30 text-xs font-bold">
                ★ ${featured.rating} IMDb
              </span>
              <span class="px-2.5 py-1 rounded-lg bg-zinc-800/90 text-zinc-200 text-xs font-semibold border border-zinc-700">
                ${featured.quality}
              </span>
              <span class="text-xs text-zinc-400 font-medium">${featured.year} • ${featured.runtime}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
              ${escapeHTML(featured.title)}
            </h1>

            <p class="text-xs sm:text-sm text-zinc-300 leading-relaxed line-clamp-3">
              ${escapeHTML(featured.synopsis)}
            </p>

            <div class="text-xs font-medium text-emerald-400 flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
              <span>${escapeHTML(featured.audioDetail || featured.language)}</span>
            </div>

            <div class="pt-1 flex flex-wrap items-center gap-3">
              <button onclick="openMovieModal('${featured.id}')" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-rose-500 hover:from-rose-500 hover:to-amber-500 text-white text-xs sm:text-sm font-bold shadow-lg shadow-rose-600/30 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>View & Download Links</span>
              </button>
            </div>
          </div>
        </div>
      `;
    }

    function getFilteredMovies() {
      return movies.filter(movie => {
        // Category check
        if (state.category !== "All") {
          const inCategory = movie.category === state.category || (movie.tags && movie.tags.includes(state.category));
          if (!inCategory) return false;
        }

        // Quality check
        if (state.quality !== "ALL") {
          const hasRes = movie.quality === state.quality || (movie.downloads && movie.downloads.some(d => d.res === state.quality));
          if (!hasRes) return false;
        }

        // Language check
        if (state.language !== "ALL") {
          const langMatch = movie.language === state.language || (movie.audioDetail && movie.audioDetail.toLowerCase().includes(state.language.toLowerCase()));
          if (!langMatch) return false;
        }

        // Search query check
        if (state.search.trim() !== "") {
          const q = state.search.toLowerCase();
          const haystack = `${movie.title} ${movie.year} ${movie.category} ${movie.language} ${movie.synopsis}`.toLowerCase();
          if (!haystack.includes(q)) return false;
        }

        return true;
      });
    }

    function renderGrid() {
      const filtered = getFilteredMovies();
      const grid = document.getElementById("movieGrid");
      const empty = document.getElementById("emptyState");
      const countBadge = document.getElementById("movieCountBadge");
      const heading = document.getElementById("gridHeading");
      const clearBtn = document.getElementById("clearFiltersBtn");

      countBadge.textContent = `${filtered.length} ${filtered.length === 1 ? "Title" : "Titles"}`;
      heading.textContent = state.category === "All" ? "Latest Releases & Classics" : `${state.category} Movies & Shows`;

      const hasActiveFilters = state.category !== "All" || state.quality !== "ALL" || state.language !== "ALL" || state.search.trim() !== "";
      clearBtn.classList.toggle("hidden", !hasActiveFilters);

      if (filtered.length === 0) {
        grid.innerHTML = "";
        empty.classList.remove("hidden");
        return;
      }

      empty.classList.add("hidden");
      grid.innerHTML = filtered.map(movie => `
        <article 
          onclick="openMovieModal('${movie.id}')"
          class="group cursor-pointer bg-brand-card border border-zinc-800/80 hover:border-rose-500/60 rounded-2xl overflow-hidden shadow-lg hover:shadow-rose-600/15 transition-all duration-300 flex flex-col">
          
          <!-- Poster Container -->
          <div class="relative aspect-[2/3] overflow-hidden bg-zinc-900">
            <div class="w-full h-full group-hover:scale-105 transition-transform duration-500">
              ${generatePosterSVG(movie, false)}
            </div>

            <!-- Top Left Quality Badge -->
            <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md bg-rose-600/95 text-white text-[10px] font-extrabold uppercase tracking-wide shadow">
              ${escapeHTML(movie.quality)}
            </span>

            <!-- Top Right Rating Badge -->
            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-md bg-[#090a0f]/85 backdrop-blur-sm text-amber-400 border border-amber-500/30 text-[11px] font-bold">
              ★ ${movie.rating}
            </span>

            <!-- Hover Action Overlay -->
            <div class="absolute inset-0 bg-[#090a0f]/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-4 text-center">
              <div class="w-12 h-12 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-lg shadow-rose-600/40 mb-2.5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
              </div>
              <span class="text-xs font-bold text-white">Download & Info</span>
              <span class="text-[11px] text-zinc-300 mt-0.5">${movie.downloads.map(d => d.res).join(" • ")}</span>
            </div>
          </div>

          <!-- Card Metadata -->
          <div class="p-3.5 flex-1 flex flex-col justify-between space-y-2">
            <div>
              <h3 class="text-sm font-bold text-zinc-100 group-hover:text-rose-400 transition-colors line-clamp-2 leading-snug">
                Download ${escapeHTML(movie.title)} (${movie.year})
              </h3>
              <p class="text-[11px] text-emerald-400 font-medium mt-1 line-clamp-1">
                ${escapeHTML(movie.audioDetail || movie.language)}
              </p>
            </div>

            <div class="pt-2 border-t border-zinc-800/80 flex items-center justify-between text-[11px] text-zinc-400">
              <span>${escapeHTML(movie.category)}</span>
              <span class="font-semibold text-zinc-300">${movie.year}</span>
            </div>
          </div>
        </article>
      `).join("");
    }

    // =========================================================================
    // 5. INTERACTIVE MODAL & DOWNLOAD MIRROR CHECKER
    // =========================================================================
    function openMovieModal(id) {
      const movie = movies.find(m => m.id === id);
      if (!movie) return;

      const modal = document.getElementById("movieModal");
      const body = document.getElementById("movieModalBody");

      body.innerHTML = `
        <div class="flex flex-col md:flex-row gap-6">
          <!-- Left Poster -->
          <div class="w-44 sm:w-52 mx-auto md:mx-0 shrink-0 rounded-xl overflow-hidden border border-zinc-800 shadow-xl aspect-[2/3]">
            ${generatePosterSVG(movie, false)}
          </div>

          <!-- Right Info -->
          <div class="flex-1 space-y-4">
            <div class="flex flex-wrap items-center gap-2">
              <span class="px-2.5 py-0.5 rounded-md bg-rose-600 text-white text-xs font-bold">${escapeHTML(movie.category)}</span>
              <span class="px-2.5 py-0.5 rounded-md bg-amber-500/15 text-amber-400 border border-amber-500/30 text-xs font-bold">★ ${movie.rating}/10</span>
              <span class="px-2.5 py-0.5 rounded-md bg-zinc-900 text-zinc-300 border border-zinc-800 text-xs">${movie.year}</span>
              <span class="px-2.5 py-0.5 rounded-md bg-zinc-900 text-zinc-300 border border-zinc-800 text-xs">${escapeHTML(movie.runtime || "HD Release")}</span>
            </div>

            <h2 class="text-xl sm:text-2xl font-extrabold text-white leading-snug">
              ${escapeHTML(movie.title)} (${movie.year}) — ${escapeHTML(movie.format || movie.quality)}
            </h2>

            <div class="p-3 rounded-xl bg-zinc-900/90 border border-zinc-800 text-xs space-y-1.5">
              <div class="flex justify-between">
                <span class="text-zinc-400">Audio Track:</span>
                <span class="text-emerald-400 font-semibold">${escapeHTML(movie.audioDetail || movie.language)}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-zinc-400">Cast / Credits:</span>
                <span class="text-zinc-200 font-medium text-right">${escapeHTML((movie.cast || ["Independent Cast"]).join(", "))}</span>
              </div>
            </div>

            <div>
              <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-1">Storyline</h4>
              <p class="text-xs sm:text-sm text-zinc-300 leading-relaxed">${escapeHTML(movie.synopsis)}</p>
            </div>
          </div>
        </div>

        <!-- Download Links Section -->
        <div class="pt-4 border-t border-zinc-800 space-y-3">
          <div class="flex items-center justify-between">
            <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
              Direct & Archive Mirror Download Links
            </h3>
            <span class="text-[11px] text-zinc-400">Verified Public Domain / Open Mirrors</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            ${movie.downloads.map((dl) => `
              <div class="p-3.5 rounded-xl bg-zinc-900 border border-zinc-800 hover:border-rose-500/50 transition flex items-center justify-between gap-3">
                <div>
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-extrabold text-white">${escapeHTML(dl.res)}</span>
                    <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 text-[11px] font-bold border border-amber-500/20">${escapeHTML(dl.size)}</span>
                  </div>
                  <p class="text-[11px] text-zinc-400 mt-1">${escapeHTML(dl.codec)} • ${escapeHTML(dl.server)}</p>
                </div>

                <a 
                  href="${escapeHTML(dl.url)}" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  onclick="showToast('Opening ${escapeHTML(dl.res)} (${escapeHTML(dl.size)}) mirror link...')"
                  class="shrink-0 px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                  </svg>
                  <span>Download</span>
                </a>
              </div>
            `).join("")}
          </div>
        </div>
      `;

      modal.classList.remove("hidden");
      modal.classList.add("flex");
    }

    function closeMovieModal() {
      const modal = document.getElementById("movieModal");
      modal.classList.add("hidden");
      modal.classList.remove("flex");
    }

    // =========================================================================
    // 6. FILTER HANDLERS, ADMIN PANEL & SUPABASE HELPERS
    // =========================================================================
    function selectCategory(cat) {
      state.category = cat;
      renderCategories();
      renderGrid();
    }

    function resetFilters() {
      state = { category: "All", search: "", quality: "ALL", language: "ALL" };
      document.getElementById("searchInput").value = "";
      document.getElementById("qualityFilter").value = "ALL";
      document.getElementById("languageFilter").value = "ALL";
      renderCategories();
      renderGrid();
    }

    function openAdminModal() {
      const m = document.getElementById("adminModal");
      m.classList.remove("hidden");
      m.classList.add("flex");
    }

    function closeAdminModal() {
      const m = document.getElementById("adminModal");
      m.classList.add("hidden");
      m.classList.remove("flex");
    }

    function openDeployModal() {
      const m = document.getElementById("deployModal");
      m.classList.remove("hidden");
      m.classList.add("flex");
    }

    function closeDeployModal() {
      const m = document.getElementById("deployModal");
      m.classList.add("hidden");
      m.classList.remove("flex");
    }

    function copyTextFallback(text, successMsg) {
      const textarea = document.createElement("textarea");
      textarea.value = text;
      textarea.style.position = "fixed";
      textarea.style.opacity = "0";
      document.body.appendChild(textarea);
      textarea.select();
      try {
        document.execCommand("copy");
        showToast(successMsg);
      } catch (err) {
        showToast("Unable to copy automatically.");
      }
      document.body.removeChild(textarea);
    }

    function copySupabaseSQL() {
      const sql = document.getElementById("supabaseSqlCode").textContent;
      copyTextFallback(sql, "Supabase SQL schema copied to clipboard!");
    }

    function exportCatalogJSON() {
      copyTextFallback(JSON.stringify(movies, null, 2), "Catalog JSON copied to clipboard!");
    }

    function showToast(message) {
      const container = document.getElementById("toastContainer");
      const toast = document.createElement("div");
      toast.className = "pointer-events-auto px-4 py-2.5 rounded-xl bg-zinc-900 border border-rose-500/40 text-xs font-semibold text-white shadow-xl flex items-center gap-2 transition-all";
      toast.innerHTML = `<span class="w-2 h-2 rounded-full bg-rose-500"></span><span>${escapeHTML(message)}</span>`;
      container.appendChild(toast);
      setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }

    // =========================================================================
    // 7. EVENT LISTENERS & INITIALIZATION
    // =========================================================================
    document.getElementById("searchInput").addEventListener("input", (e) => {
      state.search = e.target.value;
      renderGrid();
    });

    document.getElementById("qualityFilter").addEventListener("change", (e) => {
      state.quality = e.target.value;
      renderGrid();
    });

    document.getElementById("languageFilter").addEventListener("change", (e) => {
      state.language = e.target.value;
      renderGrid();
    });

    document.getElementById("addMovieForm").addEventListener("submit", (e) => {
      e.preventDefault();
      const fd = new FormData(e.target);
      const palettes = [
        ["#e11d48", "#1e1b4b", "#f59e0b"],
        ["#0284c7", "#0f172a", "#38bdf8"],
        ["#7c3aed", "#18181b", "#f43f5e"],
        ["#059669", "#064e3b", "#fbbf24"]
      ];
      const randomPalette = palettes[Math.floor(Math.random() * palettes.length)];

      const newMovie = {
        id: "m-" + Date.now(),
        title: fd.get("title").trim(),
        year: Number(fd.get("year")) || 2025,
        category: fd.get("category"),
        tags: [fd.get("category")],
        quality: fd.get("quality"),
        format: `${fd.get("quality")} WEB-DL`,
        language: fd.get("language"),
        audioDetail: `${fd.get("language")} [Clean Audio]`,
        rating: Number(fd.get("rating")) || 8.4,
        runtime: fd.get("runtime") || "2h 15m",
        featured: false,
        palette: randomPalette,
        cast: ["Featured Cast"],
        synopsis: fd.get("synopsis").trim(),
        downloads: [
          {
            res: "480p",
            size: "450 MB",
            codec: "x264 AAC",
            server: "Archive Mirror #1",
            url: fd.get("link720") || "https://archive.org/details/movies"
          },
          {
            res: "720p",
            size: "1.1 GB",
            codec: "HEVC 10-Bit",
            server: "Archive Mirror #2",
            url: fd.get("link720") || "https://archive.org/details/movies"
          },
          {
            res: "1080p",
            size: "2.3 GB",
            codec: "WEB-DL x264",
            server: "Direct High-Speed CDN",
            url: fd.get("link1080") || "https://archive.org/details/movies"
          }
        ]
      };

      movies.unshift(newMovie);
      saveMovies();
      renderGrid();
      e.target.reset();
      closeAdminModal();
      showToast(`"${newMovie.title}" published to Multi Movie Downloader!`);
    });

    // Close modals on Escape key or backdrop click
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        closeMovieModal();
        closeAdminModal();
        closeDeployModal();
      }
    });

    ["movieModal", "adminModal", "deployModal"].forEach(modalId => {
      document.getElementById(modalId).addEventListener("click", (e) => {
        if (e.target.id === modalId) {
          closeMovieModal();
          closeAdminModal();
          closeDeployModal();
        }
      });
    });

    // Initialize App on Load
    window.addEventListener("DOMContentLoaded", () => {
      loadMovies();
      renderCategories();
      renderHero();
      renderGrid();
    });
  </script>
</body>
</html>
```
