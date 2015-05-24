//
//  MessageTableViewController.swift
//  My1DayApp
//
//  Created by 清 貴幸 on 2015/04/24.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit

class MessageTableViewController: UITableViewController, PostViewControllerDelagate {
    
    private var messages : [Message] = []

    override func viewDidLoad() {
        super.viewDidLoad()
        self.setupRefreshControl()
        self.reloadMessageTableView()
    }
    
    func setupRefreshControl() {
        let refreshControl: UIRefreshControl = UIRefreshControl()
        refreshControl.attributedTitle = NSAttributedString(string: "引っ張って更新")
        refreshControl.addTarget(self, action: "reloadMessageTableView", forControlEvents: UIControlEvents.ValueChanged)
        self.refreshControl = refreshControl
    }
    
    func reloadMessageTableView() {
        APIRequest.getMessages {
            [weak self] (data, response, error) -> Void in
            
            if error != nil {
                // TODO: エラー処理
                println(error)
                return
            }
            
            if let JSONObject: AnyObject! = NSJSONSerialization.JSONObjectWithData(data, options: NSJSONReadingOptions.MutableContainers, error: nil), let JSONArray: [[String: AnyObject]] = self?.parseJSONObjectToArray(JSONObject) {
                    var messages: [Message] = []
                    for val: [String: AnyObject] in JSONArray {
                        if let message = Message(dictionary: val) {
                            messages.append(message)
                        } else {
                            println("メッセージの生成に失敗しました")
                        }
                    }
                    self?.messages = messages
                    
                    dispatch_async(dispatch_get_main_queue()) {
                        [weak self] () -> Void in
                        self?.refreshControl?.endRefreshing()
                        self?.tableView.reloadData()
                    }
            }
        }
        
        self.refreshControl?.beginRefreshing()
    }
    
    func parseJSONObjectToArray(JSONObject: AnyObject!) -> [[String: AnyObject]]? {
        if let JSONArray = JSONObject as? [[String: AnyObject]] {
            return JSONArray
        }
        
        return nil
    }

    // MARK: - Table view data source

    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        return 1
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return messages.count
    }

    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell: MessageTableViewCell = tableView.dequeueReusableCellWithIdentifier("MessageCell", forIndexPath: indexPath) as! MessageTableViewCell
        let message: Message = self.messages[indexPath.row]
        cell.setupComponentsWithMessage(message)
        return cell
    }
    
    // MARK: - IBAction
    
    @IBAction func didTouchUpOpenPostViewControllerButton(sender: AnyObject) {
        self.performSegueWithIdentifier("openPostViewController", sender: sender)
    }
    
    // MARK: - Segue
    
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        if segue.identifier == "openPostViewController" {
            let viewController: PostViewController = segue.destinationViewController as! PostViewController
            viewController.delegate = self
        }
    }
    
    // MARK: - PostViewControllerDelagate
    
    func postViewController(viewController: PostViewController, didTouchUpCloseButton: AnyObject) {
        self.presentedViewController?.dismissViewControllerAnimated(true) {
            self.reloadMessageTableView()
        }
    }
}
