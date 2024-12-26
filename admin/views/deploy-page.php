<div class="wrap">
    <h1>Site Deployment Manager</h1>

    <div class="deploy-actions">
        <button id="trigger-deploy" class="button button-primary">
            Trigger Deployment
        </button>
        <div id="deploy-status"></div>
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
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): ?>
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
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No deployment logs found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>