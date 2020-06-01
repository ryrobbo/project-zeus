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