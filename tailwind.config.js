/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./application/views/**/*.php",
		"./application/controllers/**/*.php",
		"./application/models/**/*.php",
		"./assets/js/**/*.js",
		"./assets/css/*.css",
	],

	darkMode: "class",

	theme: {
		extend: {
			colors: {
				asphalt: {
					950: "#0E0F12",
					900: "#17181C",
					800: "#22242A",
					700: "#33363E",
				},
				ember: {
					50: "#FDF1E9",
					100: "#FBDEC7",
					300: "#F2A165",
					500: "#E8580C",
					600: "#C94807",
					700: "#A33A06",
				},
				chrome: { 200: "#D8DBE0" },
				paper: { 50: "#F5F3EE" },
			},
			fontFamily: {
				display: ["Oswald", "ui-sans-serif", "system-ui"],
				sans: ["Work Sans", "ui-sans-serif", "system-ui"],
			},
		},
	},

	plugins: [],
};
