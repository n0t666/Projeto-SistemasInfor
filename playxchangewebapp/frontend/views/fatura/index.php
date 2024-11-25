<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Accordion;
use yii\widgets\MaskedInput;

?>
<style>
    .order-list {
        background-color: var(--section-background);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        padding: 1rem;
    }

    .order-item {
        background-color: var(--card-bg-left);
        border-left: 4px solid var(--primary-color);
        transition: background-color 0.3s ease;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap; 
    }

    .order-item:hover {
        background-color: var(--card-bg-right);
    }

    .order-details {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .order-poster {
        width: 80px;
        height: 120px;
        object-fit: cover;
        margin-right: 20px;
    }

    .order-item .badge {
        font-size: 0.9rem;
    }

    h2 {
        font-size: 2rem;
        color: var(--primary-color);
        border-bottom: 2px solid var(--header-line-color);
        padding-bottom: 10px;
    }

    button.btn-outline-primary {
        background-color: var(--primary-color);
        color: #121212;
        border: 1px solid var(--primary-color);
    }

    button.btn-outline-primary:hover {
        background-color: var(--primary-hover);
    }

    @media (min-width: 768px) {
        .order-list {
            padding: 2rem;
        }

        .order-item {
            font-size: 1.1rem;
        }

        .order-poster {
            width: 100px;
            height: 150px;
        }
    }

    @media (max-width: 767px) {
        .order-item {
            font-size: 1rem;
            flex-direction: column;
            text-align: center;
            padding: 10px;
        }

        .order-poster {
            width: 100%;
            max-width: 120px;
            height: auto;
            margin: 10px 0;
        }

        .order-details {
            margin-bottom: 10px;
        }

        button.btn-outline-primary {
            margin-top: 10px;
        }
    }

    img {
        max-width: 100%;
        max-height: 150px;
        width: 100%;
        height: auto;
    }

</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="order-list p-4 rounded-3 shadow-lg">
                <h2 class="text-center mb-4">Lista de encomendas</h2>
                <ul class="list-unstyled">
                    <li class="order-item d-flex justify-content-between align-items-start mb-3 p-3 rounded-2">
                        <div class="order-details d-flex align-items-center">
                            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/d2ea2f108245597.5fb969bc9f890.png" alt="Game Poster" class="order-poster rounded-2 me-3" />
                            <div>
                                <h5>Order #1</h5>
                                <p><strong>Game:</strong> Game Name 1</p>
                                <p><strong>Date:</strong> 2024-11-20</p>
                                <p><strong>Total Cost:</strong> €50.00</p>
                                <p><strong>Status:</strong> <span class="badge bg-success">Completed</span></p>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-2">See Details</button>
                    </li>
                    <li class="order-item d-flex justify-content-between align-items-start mb-3 p-3 rounded-2">
                        <div class="order-details d-flex align-items-center">
                            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/d2ea2f108245597.5fb969bc9f890.png" alt="Game Poster" class="order-poster rounded-2 me-3" />
                            <div>
                                <h5>Order #2</h5>
                                <p><strong>Game:</strong> Game Name 2</p>
                                <p><strong>Date:</strong> 2024-11-18</p>
                                <p><strong>Total Cost:</strong> €30.00</p>
                                <p><strong>Status:</strong> <span class="badge bg-warning text-dark">Pending</span></p>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-2">See Details</button>
                    </li>
                    <li class="order-item d-flex justify-content-between align-items-start mb-3 p-3 rounded-2">
                        <div class="order-details d-flex align-items-center">
                            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/d2ea2f108245597.5fb969bc9f890.png" alt="Game Poster" class="order-poster rounded-2 me-3" />
                            <div>
                                <h5>Order #3</h5>
                                <p><strong>Game:</strong> Game Name 3</p>
                                <p><strong>Date:</strong> 2024-11-15</p>
                                <p><strong>Total Cost:</strong> €70.00</p>
                                <p><strong>Status:</strong> <span class="badge bg-secondary">Shipped</span></p>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-2">See Details</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

