const fs = require('fs');
const file = 'c:/xampp/htdocs/benny_cards/routes/web.php';
let content = fs.readFileSync(file, 'utf8');

const start = content.indexOf("Route::get('/api/search-suggestions'");
const marker = "name('search.suggestions');";
const end = content.indexOf(marker, start) + marker.length;

const newRoute = `Route::get('/api/search-suggestions', function (\\Illuminate\\Http\\Request $request) {
    $q = $request->query('q', '');
    if (strlen($q) < 2) {
        return response()->json(['categories' => [], 'products' => []]);
    }
    $categories = \\App\\Models\\Category::where('status', 'active')
        ->where('title', 'LIKE', '%' . $q . '%')
        ->select('id', 'title', 'slug', 'photo')
        ->limit(4)->get()
        ->map(fn($c) => ['id' => $c->id, 'title' => $c->title, 'slug' => $c->slug, 'photo' => $c->photo]);
    $products = \\App\\Models\\Product::where('status', 'active')
        ->where(function ($query) use ($q) {
            $query->where('title', 'LIKE', '%' . $q . '%')
                  ->orWhere('summary', 'LIKE', '%' . $q . '%');
        })
        ->select('id', 'title', 'slug', 'photo', 'price')
        ->limit(6)->get()
        ->map(fn($p) => ['id' => $p->id, 'title' => $p->title, 'slug' => $p->slug, 'photo' => $p->photo, 'price' => $p->price]);
    return response()->json(['categories' => $categories, 'products' => $products]);
})->name('search.suggestions');`;

content = content.slice(0, start) + newRoute + content.slice(end);
fs.writeFileSync(file, content, 'utf8');
console.log('Done. Replaced chars ' + start + ' to ' + end);
