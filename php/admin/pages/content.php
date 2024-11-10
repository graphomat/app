<div class="content-header">
    <h1>Content Management</h1>
    <button class="btn btn-primary" onclick="toggleModal('addContentModal', true)">Add New Content</button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table" id="contentTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Content Modal -->
<div id="addContentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Content</h2>
            <button class="btn btn-text" onclick="toggleModal('addContentModal', false)">&times;</button>
        </div>
        <form id="addContentForm" onsubmit="handleContentSubmit(event)">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control">
                    <option value="page">Page</option>
                    <option value="article">Article</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="toggleModal('addContentModal', false)">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Content Modal -->
<div id="editContentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Content</h2>
            <button class="btn btn-text" onclick="toggleModal('editContentModal', false)">&times;</button>
        </div>
        <form id="editContentForm" onsubmit="handleContentEdit(event)">
            <input type="hidden" id="editId" name="id">
            <div class="form-group">
                <label for="editTitle">Title</label>
                <input type="text" id="editTitle" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editSlug">Slug</label>
                <input type="text" id="editSlug" name="slug" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editType">Type</label>
                <select id="editType" name="type" class="form-control">
                    <option value="page">Page</option>
                    <option value="article">Article</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editContent">Content</label>
                <textarea id="editContent" name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="editStatus">Status</label>
                <select id="editStatus" name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="toggleModal('editContentModal', false)">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', loadContent);

async function loadContent() {
    try {
        const content = await handleApiRequest('content');
        const tbody = document.querySelector('#contentTable tbody');
        
        if (content.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">No content found</td></tr>';
            return;
        }

        tbody.innerHTML = content.map(item => `
            <tr>
                <td>${item.title}</td>
                <td>${item.slug}</td>
                <td>${item.type}</td>
                <td><span class="badge badge-${item.status === 'published' ? 'success' : 'warning'}">${item.status}</span></td>
                <td>${new Date(item.updated_at).toLocaleString()}</td>
                <td>
                    <button class="btn btn-secondary btn-sm" onclick="editContent(${item.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteContent(${item.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Error loading content:', error);
    }
}

async function handleContentSubmit(event) {
    event.preventDefault();
    try {
        await handleFormSubmit(event.target, 'content');
        toggleModal('addContentModal', false);
        loadContent();
    } catch (error) {
        console.error('Error adding content:', error);
    }
}

async function editContent(id) {
    try {
        const content = await handleApiRequest(`content?id=${id}`);
        document.getElementById('editId').value = content.id;
        document.getElementById('editTitle').value = content.title;
        document.getElementById('editSlug').value = content.slug;
        document.getElementById('editType').value = content.type;
        document.getElementById('editContent').value = content.content;
        document.getElementById('editStatus').value = content.status;
        toggleModal('editContentModal', true);
    } catch (error) {
        console.error('Error loading content for edit:', error);
    }
}

async function handleContentEdit(event) {
    event.preventDefault();
    try {
        const id = document.getElementById('editId').value;
        await handleFormSubmit(event.target, `content/${id}`);
        toggleModal('editContentModal', false);
        loadContent();
    } catch (error) {
        console.error('Error updating content:', error);
    }
}

async function deleteContent(id) {
    if (confirm('Are you sure you want to delete this content?')) {
        try {
            await handleApiRequest(`content/${id}`, 'DELETE');
            loadContent();
        } catch (error) {
            console.error('Error deleting content:', error);
        }
    }
}

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
    document.getElementById('slug').value = slug;
});
</script>

<style>
.table-responsive {
    overflow-x: auto;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.badge-success {
    background-color: var(--success-color);
    color: white;
}

.badge-warning {
    background-color: var(--warning-color);
    color: white;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

.btn-text {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    color: var(--text-color);
}
</style>
