<!-- WhatsApp Floating Button -->
<a href="<?= waFloatButton() ?>" target="_blank" class="whatsapp-float" title="Chat CS Kami">
    <i class="fab fa-whatsapp"></i>
</a>

<style>
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    z-index: 9999;
    transition: all 0.3s ease;
    text-decoration: none;
}
.whatsapp-float:hover {
    transform: scale(1.1);
    background-color: #128C7E;
    color: white;
    text-decoration: none;
}
.whatsapp-float i {
    margin: 0;
}
</style>