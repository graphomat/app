<div class="content-header">
    <h1>Menu Management</h1>
    <button class="btn btn-primary" onclick="toggleModal('addMenuItemModal', true)">Add Menu Item</button>
</div>

<div class="card">
    <div class="menu-items-container">
        <div id="menuList" class="sortable-menu">
            Loading...
        </div>
    </div>
</div>

<!-- Add Menu Item Modal -->
<div id="addMenuItemModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Menu Item</h2>
            <button class="btn btn-text" onclick="toggleModal('addMenuItemModal', false)">&times;</button>
        </div>
        <form id="addMenuItemForm" onsubmit="handleMenuItemSubmit(event)">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" id="url" name="url" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent Menu Item</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">None</option>
                </select>
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <input type="number" id="position" name="position" class="form-control" min="0" value="0">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" checked>
                    Active
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="toggleModal('addMenuItemModal', false)">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Menu Item Modal -->
<div id="editMenuItemModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Menu Item</h2>
            <button class="btn btn-text" onclick="toggleModal('editMenuItemModal', false)">&times;</button>
        </div>
        <form id="editMenuItemForm" onsubmit="handleMenuItemEdit(event)">
            <input type="hidden" id="editId" name="id">
            <div class="form-group">
                <label for="editTitle">Title</label>
                <input type="text" id="editTitle" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editUrl">URL</label>
                <input type="text" id="editUrl" name="url" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editParentId">Parent Menu Item</label>
                <select id="editParentId" name="parent_id" class="form-control">
                    <option value="">None</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editPosition">Position</label>
                <input type="number" id="editPosition" name="position" class="form-control" min="0">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="editIsActive" name="is_active">
                    Active
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="toggleModal('editMenuItemModal', false)">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', loadMenu);

async function loadMenu() {
    try {
        const menuItems = await handleApiRequest('menu');
        const menuList = document.getElementById('menuList');
        
        if (menuItems.length === 0) {
            menuList.innerHTML = '<p>No menu items found</p>';
            return;
        }

        // Create a hierarchical menu structure
        const menuHierarchy = buildMenuHierarchy(menuItems);
        menuList.innerHTML = generateMenuHTML(menuHierarchy);
        
        // Update parent menu dropdowns
        updateParentMenuDropdowns(menuItems);
        
        // Initialize sortable functionality
        initSortable();
    } catch (error) {
        console.error('Error loading menu:', error);
    }
}

function buildMenuHierarchy(items) {
    const hierarchy = [];
    const lookup = {};
    
    // First pass: create lookup object
    items.forEach(item => {
        lookup[item.id] = { ...item, children: [] };
    });
    
    // Second pass: build hierarchy
    items.forEach(item => {
        if (item.parent_id) {
            lookup[item.parent_id].children.push(lookup[item.id]);
        } else {
            hierarchy.push(lookup[item.id]);
        }
    });
    
    return hierarchy;
}

function generateMenuHTML(items, level = 0) {
    return items.map(item => `
        <div class="menu-item" data-id="${item.id}" style="margin-left: ${level * 20}px">
            <div class="menu-item-content">
                <span class="menu-item-handle">☰</span>
                <span class="menu-item-title">${item.title}</span>
                <span class="menu-item-url">${item.url}</span>
                <span class="menu-item-status ${item.is_active ? 'active' : 'inactive'}">
                    ${item.is_active ? 'Active' : 'Inactive'}
                </span>
                <div class="menu-item-actions">
                    <button class="btn btn-secondary btn-sm" onclick="editMenuItem(${item.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteMenuItem(${item.id})">Delete</button>
                </div>
            </div>
            ${item.children.length ? generateMenuHTML(item.children, level + 1) : ''}
        </div>
    `).join('');
}

function updateParentMenuDropdowns(items) {
    const parentSelects = document.querySelectorAll('#parent_id, #editParentId');
    const options = items.map(item => 
        `<option value="${item.id}">${item.title}</option>`
    ).join('');
    
    parentSelects.forEach(select => {
        select.innerHTML = '<option value="">None</option>' + options;
    });
}

function initSortable() {
    // Initialize drag and drop functionality
    // You can use a library like Sortable.js here
}

async function handleMenuItemSubmit(event) {
    event.preventDefault();
    try {
        await handleFormSubmit(event.target, 'menu');
        toggleModal('addMenuItemModal', false);
        loadMenu();
    } catch (error) {
        console.error('Error adding menu item:', error);
    }
}

async function editMenuItem(id) {
    try {
        const menuItem = await handleApiRequest(`menu?id=${id}`);
        document.getElementById('editId').value = menuItem.id;
        document.getElementById('editTitle').value = menuItem.title;
        document.getElementById('editUrl').value = menuItem.url;
        document.getElementById('editParentId').value = menuItem.parent_id || '';
        document.getElementById('editPosition').value = menuItem.position;
        document.getElementById('editIsActive').checked = menuItem.is_active;
        toggleModal('editMenuItemModal', true);
    } catch (error) {
        console.error('Error loading menu item for edit:', error);
    }
}

async function handleMenuItemEdit(event) {
    event.preventDefault();
    try {
        const id = document.getElementById('editId').value;
        await handleFormSubmit(event.target, `menu/${id}`);
        toggleModal('editMenuItemModal', false);
        loadMenu();
    } catch (error) {
        console.error('Error updating menu item:', error);
    }
}

async function deleteMenuItem(id) {
    if (confirm('Are you sure you want to delete this menu item?')) {
        try {
            await handleApiRequest(`menu/${id}`, 'DELETE');
            loadMenu();
        } catch (error) {
            console.error('Error deleting menu item:', error);
        }
    }
}
</script>

<style>
.menu-items-container {
    margin-top: 20px;
}

.menu-item {
    margin-bottom: 10px;
}

.menu-item-content {
    display: flex;
    align-items: center;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
    gap: 15px;
}

.menu-item-handle {
    cursor: move;
    color: #666;
}

.menu-item-title {
    font-weight: bold;
    flex: 1;
}

.menu-item-url {
    color: #666;
    flex: 2;
}

.menu-item-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.menu-item-status.active {
    background-color: var(--success-color);
    color: white;
}

.menu-item-status.inactive {
    background-color: var(--warning-color);
    color: white;
}

.menu-item-actions {
    display: flex;
    gap: 5px;
}
</style>
