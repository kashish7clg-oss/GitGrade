<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$repoUrl = $data["repo_url"] ?? "";

if (!$repoUrl) {
    echo json_encode(["error" => "Repository URL required"]);
    exit;
}

$parts = explode("/", rtrim($repoUrl, "/"));
$owner = $parts[count($parts)-2];
$repo = $parts[count($parts)-1];

$apiBase = "https://api.github.com/repos/$owner/$repo";

function fetchGitHub($url) {
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: GitGrade"
        ]
    ];
    $context = stream_context_create($opts);
    return json_decode(file_get_contents($url, false, $context), true);
}

$repoData = fetchGitHub($apiBase);
$contents = fetchGitHub("$apiBase/contents");
$commits = fetchGitHub("$apiBase/commits");

$hasReadme = false;
$hasTests = false;

foreach ($contents as $file) {
    if (strtolower($file["name"]) == "readme.md") $hasReadme = true;
    if (strpos(strtolower($file["name"]), "test") !== false) $hasTests = true;
}

$fileCount = count($contents);
$commitCount = is_array($commits) ? count($commits) : 0;
$language = $repoData["language"] ?? null;

$score = 0;
if ($hasReadme) $score += 20;
if ($hasTests) $score += 20;
if ($fileCount > 5) $score += 20;
if ($commitCount > 10) $score += 20;
if ($language) $score += 20;

if ($score >= 80) {
    $summary = "Well-structured project with good coding practices.";
} elseif ($score >= 50) {
    $summary = "Decent project but needs improvements in some areas.";
} else {
    $summary = "Project lacks documentation and development consistency.";
}

$roadmap = [];

if (!$hasReadme) $roadmap[] = "Add a README with project overview and setup instructions";
if (!$hasTests) $roadmap[] = "Write unit tests to improve reliability";
if ($commitCount < 10) $roadmap[] = "Make regular commits with meaningful messages";

$roadmap[] = "Improve folder structure and naming conventions";
$roadmap[] = "Add CI/CD using GitHub Actions";

echo json_encode([
    "score" => $score,
    "summary" => $summary,
    "roadmap" => $roadmap
]);
?>
