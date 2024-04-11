<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lazy Loading Example</title>
<style>
  #container {
    width: 80%;
    margin: auto;
  }
  #items {
    margin-top: 20px;
  }
  .item {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
  }
</style>
</head>
<body>

<div id="container">
  <h2>Lazy Loading Example</h2>
  <div id="items">
    <!-- Initially empty, items will be loaded here -->
  </div>
  <div id="loading" style="display: none;">Loading...</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  let page = 1;
  let loading = false;

  function loadItems() {
    if (loading) return; // Avoid multiple simultaneous requests
    loading = true;
    document.getElementById('loading').style.display = 'block';

    // Simulated AJAX request to fetch items from server
    setTimeout(function() {
      fetch('/path/to/server/script.php?page=' + page)
        .then(response => response.json())
        .then(data => {
          loading = false;
          document.getElementById('loading').style.display = 'none';
          if (data.length > 0) {
            appendItems(data);
            page++;
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
          loading = false;
          document.getElementById('loading').style.display = 'none';
        });
    }, 1000); // Simulated delay for demo
  }

  function appendItems(items) {
    const itemsContainer = document.getElementById('items');
    items.forEach(item => {
      const itemElement = document.createElement('div');
      itemElement.className = 'item';
      itemElement.textContent = item.name; // Example: assuming 'name' property exists
      itemsContainer.appendChild(itemElement);
    });
  }

  // Load more items when user scrolls to bottom
  window.addEventListener('scroll', function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
      loadItems();
    }
  });

  // Initial load
  loadItems();
});
</script>

</body>
</html>
