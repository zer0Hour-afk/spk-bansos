import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Theme (dark / light) toggle
function applyTheme(theme) {
	const root = document.documentElement;
	if (theme === 'dark') {
		root.classList.add('dark');
	} else {
		root.classList.remove('dark');
	}
}

// initialize theme from localStorage or system preference
(function () {
	try {
		const stored = localStorage.getItem('theme');
		if (stored) {
			applyTheme(stored);
		} else {
			const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			applyTheme(prefersDark ? 'dark' : 'light');
		}
	} catch (e) {
		// ignore
	}
})();

window.toggleTheme = function () {
	try {
		const root = document.documentElement;
		const isDark = root.classList.contains('dark');
		const next = isDark ? 'light' : 'dark';
		applyTheme(next);
		localStorage.setItem('theme', next);
		// update any theme icons
		document.querySelectorAll('[data-theme-toggle]').forEach(function (el) {
			el.dataset.theme = next;
		});
	} catch (e) {
		// ignore
	}
};

// Update theme icon state on load
document.addEventListener('DOMContentLoaded', function () {
	try {
		const root = document.documentElement;
		const isDark = root.classList.contains('dark');
		document.querySelectorAll('[data-theme-toggle]').forEach(function (el) {
			el.dataset.theme = isDark ? 'dark' : 'light';
			// set icon content
			el.innerHTML = isDark ? sunIcon() : moonIcon();
		});

		// set icon for any theme toggle buttons when theme changes
		const observer = new MutationObserver(function () {
			const dark = document.documentElement.classList.contains('dark');
			document.querySelectorAll('[data-theme-toggle]').forEach(function (el) {
				el.dataset.theme = dark ? 'dark' : 'light';
				el.innerHTML = dark ? sunIcon() : moonIcon();
			});
		});
		observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
	} catch (e) {}
});

function sunIcon() {
	return '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v1m0 16v1m8.66-12.34l-.7.7M4.04 19.96l-.7.7M21 12h-1M4 12H3m15.66 4.66l-.7-.7M6.34 6.34l-.7-.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
}

function moonIcon() {
	return '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
}

// Accessibility: font size and high contrast
window.toggleLargeText = function () {
	try {
		const root = document.documentElement;
		const large = root.classList.toggle('text-lg');
		localStorage.setItem('largeText', large ? '1' : '0');
	} catch (e) {}
};

window.toggleHighContrast = function () {
	try {
		const root = document.documentElement;
		const high = root.classList.toggle('high-contrast');
		localStorage.setItem('highContrast', high ? '1' : '0');
	} catch (e) {}
};

// restore accessibility prefs
(function () {
	try {
		const large = localStorage.getItem('largeText');
		if (large === '1') document.documentElement.classList.add('text-lg');
		const high = localStorage.getItem('highContrast');
		if (high === '1') document.documentElement.classList.add('high-contrast');
	} catch (e) {}
})();
