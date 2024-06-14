async function fetchCategories() {
    const response = await fetch('book_category.php?action=fetch');
    const categories = await response.json();
    const tableBody = document.getElementById('categoryTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
    categories.forEach(category => {
        const row = tableBody.insertRow();
        row.innerHTML = `
            <td>${category.category_id}</td>
            <td>${category.category_Name}</td>
            <td>${category.date_modified}</td>
            <td>
                <button onclick="deleteCategory('${category.category_id}')">Delete</button>
            </td>
        `;
    });
}

async function submitCategory() {
    const categoryID = document.getElementById('categoryID').value;
    const categoryName = document.getElementById('categoryName').value;
    const formData = new FormData();
    formData.append('action', 'submit');
    formData.append('category_id', categoryID);
    formData.append('category_Name', categoryName);

    const response = await fetch('book_category.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.text();
    alert(result);
    fetchCategories();
}

async function deleteCategory(categoryID) {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('category_id', categoryID);

    const response = await fetch('book_category.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.text();
    alert(result);
    fetchCategories();
}

fetchCategories();
