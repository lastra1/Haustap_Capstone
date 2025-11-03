if (!window.servicesScriptLoaded) {
  window.servicesScriptLoaded = true;

  document.addEventListener("DOMContentLoaded", async () => {
    const container = document.getElementById("services-container");
    const categorySelect = document.getElementById("categorySelect");

    if (!container || !categorySelect) {
      console.warn("⚠️ Missing container or categorySelect element.");
      return;
    }

    let loading = false;
    const categoryId = window.SELECTED_CATEGORY_ID || '';

    async function loadCategories(selectedId = '') {
      try {
        const res = await fetch(window.API_CATEGORIES_ENDPOINT);
        if (!res.ok) throw new Error("Failed to load categories");

        const categories = await res.json();
        categorySelect.innerHTML =
          '<option value="">All Categories</option>' +
          categories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('');

        if (selectedId) categorySelect.value = selectedId;
      } catch (err) {
        console.error(err);
        categorySelect.innerHTML = '<option value="">Failed to load</option>';
      }
    }

    async function loadServices(catId = '') {
      if (loading) return;
      loading = true;

      try {
        container.innerHTML = '<p>Loading services...</p>';
        let endpoint = window.API_SERVICES_ENDPOINT;
        if (catId) endpoint += `?category_id=${catId}`;

        const res = await fetch(endpoint);
        if (!res.ok) throw new Error("Failed to load services");

        const services = await res.json();
        if (!services.length) {
          container.innerHTML = '<p>No services found for this category.</p>';
          return;
        }

        container.innerHTML = services.map(service => `
          <div class="service-card">
            <img src="images/${service.service_name.toLowerCase().replace(/\s+/g, '-')}.png"
                 alt="${service.service_name}"
                 onerror="this.src='images/placeholder.png'">
            <div class="service-content">
              <h3>${service.service_name}</h3>
              <p>${service.description}</p>
              <strong>₱${service.price}</strong>
            </div>
          </div>
        `).join('');
      } catch (err) {
        console.error(err);
        container.innerHTML = '<p>Failed to load services.</p>';
      } finally {
        loading = false;
      }
    }

    // ✅ INITIAL LOAD
    await loadCategories(categoryId);
    await loadServices(categoryId);

    // ✅ DROPDOWN CHANGE
    categorySelect.addEventListener("change", async () => {
      const selected = categorySelect.value;
      const newUrl = selected ? `?category_id=${selected}` : window.location.pathname;
      window.history.pushState({}, "", newUrl);
      await loadServices(selected);
    });
  });
}
