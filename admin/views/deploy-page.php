?>
    <div class="wrap deploy-manager">
        <h1>Site Deployment</h1>
        
        <div class="deploy-section">
            <div class="deploy-card">
                <h2>Deploy Your Site</h2>
                <p>Click the button below to trigger a new deployment of your static site.</p>
                <button id="trigger-deploy" class="deploy-button">
                    <span class="button-text">Deploy Site</span>
                    <div class="loader"></div>
                </button>
            </div>
        </div>
        
        <div class="deploy-logs">
            <div class="logs-card">
                <h2>Recent Deployments</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($logs as $log): ?>
                                <tr>
                                    <td><?php echo esc_html($log->deploy_time); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo esc_attr(strtolower($log->status)); ?>">
                                            <?php echo esc_html($log->status); ?>
                                        </span>
                                    </td>
                                    <td><?php echo esc_html($log->response_message); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php