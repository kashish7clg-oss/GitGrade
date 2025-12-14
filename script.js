function analyzeRepo() {
    const repoUrl = document.getElementById("repoUrl").value;
    if (!repoUrl) {
        alert("Please enter a repository URL");
        return;
    }

    fetch("analyze.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ repo_url: repoUrl })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("result").classList.remove("hidden");
        document.getElementById("score").innerText = data.score + " / 100";
        document.getElementById("summary").innerText = data.summary;

        const roadmapList = document.getElementById("roadmap");
        roadmapList.innerHTML = "";

        data.roadmap.forEach(step => {
            const li = document.createElement("li");
            li.innerText = step;
            roadmapList.appendChild(li);
        });
    })
    .catch(() => alert("Error analyzing repository"));
}
