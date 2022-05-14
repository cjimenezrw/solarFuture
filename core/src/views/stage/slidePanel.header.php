<header class="slidePanel-header bg-green-600">
    <div class="slidePanel-actions" aria-label="actions" role="group">
        <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close" aria-hidden="true" onclick="core.closePanelModule();"></button>
    </div>
    <h1><?php echo $_SESSION['modulos'][$this->sysController]['titulo']; ?></h1>
</header>
<div class="slidePanel-inner">
    <section class="slidePanel-inner-section">