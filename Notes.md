# Project Zeus

1. Spelling and grammar mistakes
2. Find broken links and images
3. See how website appears on mobile devices
4. Search rankings for keywords on specific devices from specific locations
5. Improvement actions
6. WCAG 2.1 compliance - mobile too

Launch a browserless chrome instance

```bash
docker run -e "DEFAULT_LAUNCH_ARGS=[\"--window-size=1920,1080\"]" -p 3000:3000 browserless/chrome
```

### Test CURL commands

Get page source:

```bash
curl -X POST \
  http://localhost:3000/content \
  -H 'Content-Type: application/json' \
  -d '{
	"url": "http://ryrobbo.com",
	"gotoOptions": {
		"waitUntil": "networkidle2"
	}
}'
```

Take screenshot:

```bash
curl -X POST \
  http://localhost:3000/screenshot \
  -H 'Content-Type: application/json' \
  -d '{
	"url": "http://ryrobbo.com",
	"options": {
	    "fullPage": true
	},
	"gotoOptions": {
		"waitUntil": "networkidle2"
	},
	"viewport": {
        "width": 1920,
        "height": 1080
    }
}' --output xxxx.jpg
```

## TODO

1. todo