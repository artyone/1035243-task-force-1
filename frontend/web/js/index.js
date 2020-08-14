/*
// autoComplete.js on type event emitter
document.querySelector("#autoComplete").addEventListener("autoComplete", function (event) {
  console.log(event.detail);
  // console.log(autoCompletejs);
});

// The autoComplete.js Engine instance creator
const autoCompletejs = new autoComplete({
  data: {
    src: async function () {
      // Loading placeholder text
      document.querySelector("#autoComplete").setAttribute("placeholder", "Введите адрес");
      // User search query
      const query = document.querySelector("#autoComplete").value;
      // Fetch External Data Source
      const source = await fetch(`/ajax?getAddress=${query}`);
      const data = await source.json();
      // Returns Fetched data
      return data;
    },
    key: ["food", "cities", "animals"],
  },
  sort: function (a, b) {
    if (a.match < b.match) {
      return -1;
    }
    if (a.match > b.match) {
      return 1;
    }
    return 0;
  },
  query: {
    manipulate: function (query) {
      return query.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    },
  },
  trigger: {
    event: ["input","focusin", "focusout"],
    condition: function (query) {
      return !!query.replace(/ /g, "").length && query !== "hamburger";
    },
  },
  placeHolder: "Food & Drinks",
  selector: "#autoComplete",
  debounce: 0,
  searchEngine: "strict",
  highlight: true,
  maxResults: 5,
  resultsList: {
    render: true,
    container: function (source) {
      source.setAttribute("id", "autoComplete_list");
    },
    element: "ul",
    destination: document.querySelector("#autoComplete"),
    position: "afterend",
  },
  resultItem: {
    content: function (data, source) {
      source.innerHTML = data.match;
    },
    element: "li",
  },
  noResults: function () {
    const result = document.createElement("li");
    result.setAttribute("class", "no_result");
    result.setAttribute("tabindex", "1");
    result.innerHTML = "No Results";
    document.querySelector("#autoComplete_list").appendChild(result);
  },
  onSelection: function (feedback) {
    document.querySelector("#autoComplete").blur();
    const selection = feedback.selection.value.food;
    // Render selected choice to selection div
    document.querySelector(".selection").innerHTML = selection;
    // Clear Input
    document.querySelector("#autoComplete").value = "";
    // Change placeholder with the selected value
    document.querySelector("#autoComplete").setAttribute("placeholder", selection);
    // Concole log autoComplete data feedback
    console.log(feedback);
  },
});

// Toggle Search Engine Type/Mode
document.querySelector(".toggeler").addEventListener("click", function () {
  // Holdes the toggle buttin alignment
  const toggele = document.querySelector(".toggele").style.justifyContent;

  if (toggele === "flex-start" || toggele === "") {
    // Set Search Engine mode to Loose
    document.querySelector(".toggele").style.justifyContent = "flex-end";
    document.querySelector(".toggeler").innerHTML = "Loose";
    autoCompletejs.searchEngine = "loose";
  } else {
    // Set Search Engine mode to Strict
    document.querySelector(".toggele").style.justifyContent = "flex-start";
    document.querySelector(".toggeler").innerHTML = "Strict";
    autoCompletejs.searchEngine = "strict";
  }
});

// Toggle results list and other elements
const action = function (action) {
  const github = document.querySelector(".github-corner");
  const title = document.querySelector("h1");
  const mode = document.querySelector(".mode");
  const selection = document.querySelector(".selection");
  const footer = document.querySelector(".footer");

  if (action === "dim") {
    github.style.opacity = 1;
    title.style.opacity = 1;
    mode.style.opacity = 1;
    selection.style.opacity = 1;
    footer.style.opacity = 1;
  } else {
    github.style.opacity = 0.1;
    title.style.opacity = 0.3;
    mode.style.opacity = 0.2;
    selection.style.opacity = 0.1;
    footer.style.opacity = 0.1;
  }
};

// Toggle event for search input
// showing & hidding results list onfocus / blur
["focus", "blur"].forEach(function (eventType) {
  const resultsList = document.querySelector("#autoComplete_list");

  document.querySelector("#autoComplete").addEventListener(eventType, function () {
    // Hide results list & show other elemennts
    if (eventType === "blur") {
      action("dim");
      resultsList.style.display = "none";
    } else if (eventType === "focus") {
      // Show results list & hide other elemennts
      action("light");
      resultsList.style.display = "block";
    }
  });

});
*/
// autoComplete.js on typing event emitter
document.querySelector("#autoComplete").addEventListener("autoComplete", event => {
  console.log(event);
});
// The autoComplete.js Engine instance creator
new autoComplete({
  data: {                              // Data src [Array, Function, Async] | (REQUIRED)
    src: async () => {
      // User search query
      const query = document.querySelector("#autoComplete").value;
      // Fetch External Data Source
      const source = await fetch(`/ajax?getAddress=${query}`);
      // Format data into JSON
      const data = await source.json();
      // Return Fetched data
      return data;
    },
    key: ["title"],
    cache: false
  },
  query: {                               // Query Interceptor               | (Optional)
    manipulate: (query) => {
      return query.replace("pizza", "burger");
    }
  },
  sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
    if (a.match < b.match) return -1;
    if (a.match > b.match) return 1;
    return 0;
  },
  placeHolder: "Введите адрес",     // Place Holder text                 | (Optional)
  selector: "#autoComplete",           // Input field selector              | (Optional)
  threshold: 3,                        // Min. Chars length to start Engine | (Optional)
  debounce: 300,                       // Post duration for engine to start | (Optional)
  searchEngine: "strict",              // Search Engine type/mode           | (Optional)
  resultsList: {                       // Rendered results list object      | (Optional)
    render: true,
    /* if set to false, add an eventListener to the selector for event type
       "autoComplete" to handle the result */
    container: source => {
      source.setAttribute("id", "food_list");
    },
    destination: document.querySelector("#autoComplete"),
    position: "afterend",
    element: "ul"
  },
  maxResults: 5,                         // Max. number of rendered results | (Optional)
  highlight: true,                       // Highlight matching results      | (Optional)
  resultItem: {                          // Rendered result item            | (Optional)
    content: (data, source) => {
      source.innerHTML = data.match;
    },
    element: "li"
  },
  noResults: () => {                     // Action script on noResults      | (Optional)
    const result = document.createElement("li");
    result.setAttribute("class", "no_result");
    result.setAttribute("tabindex", "1");
    result.innerHTML = "No Results";
    document.querySelector("#autoComplete_list").appendChild(result);
  },
  onSelection: feedback => {             // Action script onSelection event | (Optional)
    console.log(feedback.selection.value.image_url);
  }
});