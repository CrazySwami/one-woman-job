#!/bin/bash
#
# Sync from GitHub - Pull latest changes from origin (GitHub)
# Usage: ./sync-from-github.sh
#
# This script:
# 1. Stashes any local uncommitted changes
# 2. Pulls from GitHub (origin)
# 3. Applies stashed changes back (if any)
# 4. Syncs the theme to the Docker container
#

REPO_DIR="/root/repos/one-woman-job"
DOCKER_CONTAINER="owj-wordpress"
THEME_PATH="/var/www/html/wp-content/themes/one-woman-job"

cd "$REPO_DIR" || exit 1

echo "=== Syncing One Woman Job from GitHub ==="
echo "Repository: $REPO_DIR"
echo ""

# Check for uncommitted changes
if [[ -n $(git status --porcelain) ]]; then
    echo "📦 Stashing local changes..."
    git stash push -m "Auto-stash before GitHub sync $(date '+%Y-%m-%d %H:%M:%S')"
    STASHED=true
else
    STASHED=false
fi

# Fetch from GitHub
echo "🔄 Fetching from GitHub..."
git fetch origin

# Get current branch
BRANCH=$(git branch --show-current)
echo "📍 Current branch: $BRANCH"

# Check if we're behind
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/$BRANCH 2>/dev/null)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ Already up to date with GitHub"
else
    echo "⬇️  Pulling changes from origin/$BRANCH..."
    git pull origin "$BRANCH"

    if [ $? -eq 0 ]; then
        echo "✅ Successfully pulled from GitHub"

        # Send notification
        curl -s -H "Title: GitHub Sync" -H "Tags: arrows_counterclockwise" \
            -d "one-woman-job synced from GitHub" \
            ntfy.sh/hustleserver > /dev/null 2>&1
    else
        echo "❌ Pull failed - you may need to resolve conflicts"
        exit 1
    fi
fi

# Restore stashed changes if any
if [ "$STASHED" = true ]; then
    echo "📦 Restoring stashed changes..."
    git stash pop
fi

# Verify Docker container is running and sync
if docker ps --format '{{.Names}}' | grep -q "$DOCKER_CONTAINER"; then
    echo ""
    echo "🐳 Docker container $DOCKER_CONTAINER is running"
    echo "   Theme is live-mounted - changes are immediate"
else
    echo ""
    echo "⚠️  Docker container $DOCKER_CONTAINER is not running"
    echo "   Start with: cd docker && docker-compose up -d"
fi

echo ""
echo "=== Sync Complete ==="
