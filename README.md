# GitGrade – GitHub Repository Analyzer

## Overview
GitGrade is a web-based system that analyzes GitHub repositories and converts them into
a meaningful score, evaluation summary, and personalized improvement roadmap.


## Tech Stack
- HTML, CSS, JavaScript
- PHP (Backend)
- GitHub REST API


## How It Works
1. User enters a public GitHub repository URL
2. PHP backend fetches repository data using GitHub API
3. Repository is evaluated on:
   - Documentation
   - Testing
   - File structure
   - Commit history
4. System generates:
   - Score (0–100)
   - Written summary
   - Actionable roadmap


## How to Run
- Place files in XAMPP / WAMP `htdocs` folder
- Start Apache server
- Open `index.html` in browser


## Sample Output

Score: 78 / 100  
Summary: Decent project but needs improvements.  

Roadmap:
- Add README
- Write tests
- Improve commits
- Add CI/CD


## Hackathon Use Case
This project helps students understand how their GitHub projects appear to recruiters
and guides them to improve real-world coding practices.
